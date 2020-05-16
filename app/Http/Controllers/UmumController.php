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
                => 'Email anda belum terdaftar. Silahkan <a href="'. route('signup') .'" class="font-weight-bold text-success">Buat Akun</a> terlebih dahulu.']
            )->withInput($request->all());

        if( auth()->attempt($request->only(['email', 'password']), $request->login_remember))
        {
            if( auth()->user()->email_verified_at == null )
            {
                auth()->logout();
                return redirect()->route('login')->with('informasi', [
                    'type' => 'danger',
                    'value' => "Mohon maaf, anda belum melakukan verifikasi email. Silahkan cek Inbox <b>$request->email</b> anda (cek juga folder Spam)."]
                )->withInput($request->all());
            }

            auth()->logoutOtherDevices($request->password);
            event(new \App\Events\UserStateChanged(auth()->user()->remember_token, 'refresh'));

            if( auth()->user()->is_admin ) return redirect()->route('admin.beranda');
            else return redirect()->route('user.beranda');
        }

        return redirect()->back()->with('informasi', ['type' => 'warning', 'value'
            => 'Kata sandi salah, silahkan coba lagi.'])->withInput($request->all());

    }

    public function get_signup()
    {
        $ranting = \App\Ranting::all();
        return view('signup', compact(['ranting']));
    }

    public function post_signup(Request $request)
    {
        $this->validate($request, [
            'sign-nama' => 'required|min:3|profanity',
            'sign-email' => 'required|email|unique:users,email',
            'sign-ranting' => 'required|exists:ranting,id',
            'sign-pass' => 'required|min:8',
            'sign-agree' => 'required',
            'sign-foto' => 'mimes:jpeg,jpg,JPG,png',
        ],[
            'sign-email.unique' => 'Email tersebut sudah digunakan. Silahkan '.
                '<a href="'. route('login') .'">Masuk</a>'.
                ' atau '.
                '<a href="'. route('reset_pass') .'">Ubah Kata Sandi</a>',

            'sign-nama.profanity' => "Nama mengandung kata kotor."
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
        $account->name = ucwords(strtolower($request->{'sign-nama'}));
        $account->email = $request->{'sign-email'};
        $account->remember_token = \Str::random(60);
        $account->ranting = \App\Ranting::find($request->{'sign-ranting'})->name;
        $account->password = bcrypt($request->{'sign-pass'});
        $account->avatar = $filename ?: null;
        $account->save();

        \Mail::to($account->email)->send(new \App\Mail\VerifikasiAkun($account));

        return redirect()->route('login')->with('informasi', [
            'type' => 'success',
            'value' => "Pendaftaran berhasil. Silahkan cek Inbox <b>$account->email</b> untuk melakukan verifikasi. Jika belum ada, tunggu hingga 5 menit."]
        );
        
    }

    public function get_verifikasi(Request $request)
    {
        if( empty($request->token) )
            abort(404);

        try {
            $email = \Crypt::decrypt(request('token'));
        } catch (DecryptException $e) {
            return redirect()->route('login')->with('informasi', [
                'type' => 'warning',
                'value' => "Alamat verifikasi tidak valid."]
            );
        }
        $account = \App\User::whereEmail($email)->first();

        if( $account->email_verified_at )
            return redirect()->route('login')->with('informasi', [
                'type' => 'warning',
                'value' => "Verifikasi akun tidak diperlukan karena $email sudah diaktifkan. Silahkan masuk."]
            );

        $account->email_verified_at = \Carbon\Carbon::now();
        $account->save();

        return redirect()->route('login')->with('informasi', [
            'type' => 'success',
            'value' => "Akun $account->name berhasil verifikasi. Silahkan login."]
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
            'email.exists' => 'Email belum didaftarkan',
            'captcha.captcha' => 'Captcha tidak sesuai'
        ]);

        $account = \App\User::whereEmail($request->email)->get()->first();

        \Mail::to($account->email)->send(new \App\Mail\LupaSandi($account));

        return redirect()->route('login')->with('informasi', [
            'type' => 'success',
            'value' => "Silahkan cek inbox <b>$request->email</b> untuk mengatur kata sandi."]
        );

    }

    public function gantisandi(Request $request, $link)
    {
        $kunci = explode(config('app.reset_pass_glue'), $link);
        $kunci = array_reverse($kunci);
        $kunci[0] = urlencode($kunci[0]);

        if( !\Storage::disk('reset_pass')->exists($kunci[0]) )
            return redirect()->route('login')->with('informasi', [
                'type' => 'warning',
                'value' => 'Alamat ubah kata sandi tidak tersedia atau sudah digunakan. Anda bisa melakukan '.
                    '<a href="'. route('reset_pass') .'">permintaan ubah kata sandi</a> kembali.' ]
            );
        
        $data = json_decode(\Storage::disk('reset_pass')->get($kunci[0]));
        if( \App\User::whereEmail($data->email)->count() != 1 )
        {
            \Storage::disk('reset_pass')->delete($kunci[0]);
            return redirect()->route('login')->with('informasi', [
                'type' => 'warning',
                'value' => "Akun anda belum diverifikasi. Silahkan cek pesan Verifikasi Akun pada inbox $email_parsed, ".
                "coba juga cek folder <b>Spam</b>."]
            );
        }

        if( $data->token !== $kunci[1] )
        {
            \Storage::disk('reset_pass')->delete($kunci[0]);
            return redirect()->route('login')->with('informasi', [
                'type' => 'warning',
                'value' => 'Terdapat konflik pada kunci ubah kata sandi. Anda bisa melakukan '.
                    '<a href="'. route('reset_pass') .'">permintaan ubah kata sandi</a> kembali.' ]
            );
        }

        if( $data->expired <= time() )
        {
            \Storage::disk('reset_pass')->delete($kunci[0]);
            return redirect()->route('login')->with('informasi', [
                'type' => 'warning',
                'value' => 'Alamat ubah kata sandi sudah kadaluarsa. Anda bisa melakukan '.
                    '<a href="'. route('reset_pass') .'">permintaan ubah kata sandi</a> kembali.' ]
            );
        }

        if( $request->has('password') )
        {
            $request->validate([
                'password' => 'required|min:8|confirmed',
            ]);

            $user = \App\User::whereEmail($data->email)->get()->first();
            $user->password = bcrypt($request->password);
            $user->save();

            \Storage::disk('reset_pass')->delete($kunci[0]);
            return redirect()->route('login')->with('informasi', [
                'type' => 'success',
                'value' => 'Kata sandi berhasil diganti. Silahkan masuk.']
            );
        }

        $email = $data->email;
        return view('set_pass', compact(['email', 'link']));
    }
}
