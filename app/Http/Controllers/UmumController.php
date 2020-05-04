<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Contracts\Encryption\DecryptException;

class UmumController extends Controller
{

    public function get_login()
    {
        return view('login');
    }

    public function post_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if( \App\User::whereEmail($request->email)->count() !== 1 )
            return redirect()->back()->with('informasi', ['type' => 'warning', 'value'
                => 'Email anda belum terdaftar pada basis data kami.']);

        if( auth()->attempt($request->only(['email', 'password']), $request->login_remember))
        {
            if( auth()->user()->email_verified_at == null )
            {
                auth()->logout();
                return redirect()->route('login')->with('informasi', [
                    'type' => 'danger',
                    'value' => 'Mohon maaf, anda belum melakukan verifikasi email. Silahkan cek Pesan Masuk pada penyedia layanan email anda.']
                );
            }

            auth()->logoutOtherDevices($request->password);
            event(new \App\Events\UserStateChanged(auth()->user()->remember_token, 'refresh'));

            if( auth()->user()->is_admin )
                return redirect()->route('admin.beranda');

            else return redirect()->route('user.beranda');
        }

        return redirect()->back()->with('informasi', ['type' => 'warning', 'value'
            => 'Kata sandi salah, silahkan coba lagi.']);

    }

    public function get_signup()
    {
        $ranting = \App\Ranting::all();
        return view('signup', compact(['ranting']));
    }

    public function post_signup(Request $request)
    {
        $this->validate($request, [
            'sign-nama' => 'required|min:3',
            'sign-email' => 'required|email|unique:users,email',
            'sign-ranting' => 'required|exists:ranting,id',
            'sign-pass' => 'required|min:8',
            'sign-agree' => 'required',
            'sign-foto' => 'mimes:jpeg,jpg,JPG,png',
        ],[
            'sign-email.unique' => 'Email tersebut sudah digunakan'
        ]);

        $filename = "";
        if( $file = $request->file('sign-foto') )
        {
            $filename = Str::random(20) .'_'. time() .'.'. $file->getClientOriginalExtension();
            $file->move(public_path() . '/data/users_img/' , $filename);
            $img = \Image::make(public_path() . '/data/users_img/' . $filename);
            $img->fit(500);
            $img->save(public_path() . '/data/users_img/' . $filename);
        }
        

        $account = new \App\User;
        $account->name = ucwords($request->{'sign-nama'});
        $account->email = $request->{'sign-email'};
        $account->ranting = \App\Ranting::find($request->{'sign-ranting'})->name;
        $account->password = bcrypt($request->{'sign-pass'});
        $account->avatar = $filename ?: null;
        $account->save();

        \Mail::to($account->email)->send(new \App\Mail\VerifikasiAkun($account));

        return redirect()->route('login')->with('informasi', [
            'type' => 'success',
            'value' => 'Pendaftaran berhasil. Silahkan cek email anda.']
        );
        
    }

    public function get_verifikasi(Request $request)
    {
        if( empty($request->token) )
            abort(404);

        $email = \Crypt::decrypt(request('token'));
        $account = \App\User::whereEmail($email)->first();

        if( $account->email_verified_at )
            abort(404);

        $account->email_verified_at = \Carbon\Carbon::now();
        $account->save();

        return redirect()->route('login')->with('informasi', [
            'type' => 'success',
            'value' => "Akun $account->name berhasil diaktivasi. Silahkan login."]
        );

    }

    public function logout(Request $request)
    {
        if( isset($request->userID) )
        {
            $playerID = $request->userID;
            $fields = array( 
                'app_id' => config('app.onesignal_appID'),
                'tags' => array(
                    'userID' => 'none',
                    'isAdmin' => 'none'
                )
            ); 
            $fields = json_encode($fields); 

            $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/players/'.$playerID); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
            curl_setopt($ch, CURLOPT_HEADER, false); 
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields); 
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
            curl_exec($ch); 
            curl_close($ch);
        }

        auth()->logout();
        \Session::flush();

        return response()->json('Sukses', 200);
    }

    public function get_broadcast($slug)
    {
        $pesan = \App\Broadcast::where(['slug' => $slug])->get();
        if( $pesan->count() == 0 )
            abort(404);
        
        $pesan = $pesan->first();
        return view('broadcast', compact(['pesan']));
    }

    public function post_reset(Request $request)
    {
        $this->validate($request, [
            'captcha' => 'required|captcha',
            'email' => 'required|exists:users,email'
        ],[
            'email.exists' => 'Email tidak terdaftar',
            'captcha.captcha' => 'Captcha tidak valid'
        ]);

        $account = \App\User::whereEmail($request->email)->get()->first();

        \Mail::to($account->email)->send(new \App\Mail\LupaSandi($account));

        return redirect()->route('login')->with('informasi', [
            'type' => 'success',
            'value' => 'Alamat untuk mengatur ulang kata sandi telah kami kirim ke email anda']
        );

    }

    public function gantisandi(Request $request, $link)
    {
        try{
            $url = decrypt($link);
        }
        catch(DecryptException $e)
        {
            abort(403, 'Token tidak valid');
        }
        $email = $url->token;
        
        if( \App\User::whereEmail($email)->count() != 1 )
        {
            return redirect()->route('login')->with('informasi', [
                'type' => 'warning',
                'value' => 'Email anda sudah tidak aktif']
            );
        }
        
        if( $url->expired <= time() )
        {
            return redirect()->route('login')->with('informasi', [
                'type' => 'warning',
                'value' => 'Alamat untuk mengganti sandi sudah kadaluarsa']
            );
        }

        if( $request->has('password') )
        {
            $request->validate([
                'password' => 'required|min:8|confirmed',
            ]);

            $user = \App\User::whereEmail($email)->get()->first();
            $user->password = bcrypt($request->password);
            $user->save();

            return redirect()->route('login')->with('informasi', [
                'type' => 'success',
                'value' => 'Kata sandi berhasil diganti. Silahkan masuk.']
            );
        }

        return view('set_pass', compact(['email', 'link']));
    }
}
