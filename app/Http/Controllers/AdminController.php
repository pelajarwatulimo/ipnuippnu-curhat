<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OneSignal;

class AdminController extends Controller
{
    
    public function get_beranda()
    {
        $curhatan = \App\Message::all();
        return view('admin.beranda', compact(['curhatan']));
    }

    public function get_pesan($id)
    {
        $pesan = \App\Message::find($id);
        return view('admin.viewPesan', compact(['pesan']));
    }

    public function post_pesan(Request $request, $id)
    {
        $request->validate([
            'balasan' => 'required'
        ]);

        if( \App\Message::find($id) == null )
            return response()->json(['status' => 'error', 'messages' => 'Pesan tidak ditemukan'], 404);

        $balasan = new \App\MessageAnswer;
        $balasan->user_id = auth()->user()->id;
        $balasan->user_read = 0;
        $balasan->admin_read = 1;
        $balasan->message = $request->balasan;
        $balasan->message_id = $id;
        $balasan->save();

        $tujuan = \App\Message::find($id);

        OneSignal::async()->sendNotificationUsingTags(
            auth()->user()->panggilan() . " telah membalas curhatan anda.",
            array(["field" => "tag", "key" => "userID", "relation" => "=", "value" => $tujuan->user->remember_token]),
            $url = route('user.pesan.view', $id),
            $data = null,
            $buttons = null,
            $schedule = null,
            $headings = "Curhatan Telah Dibalas!"
        );

        $aciap = new \stdClass;
        $aciap->id = $balasan->message_id;
        $aciap->name = $balasan->user->name;
        $aciap->avatar = $balasan->user->avatar ?: 'default.jpg';
        $aciap->message = $balasan->message;
        $aciap->created_at = $balasan->updated_at->format('d M h:i a');
        $aciap->kunci = $request->client_id;
        $aciap->answer_id = $balasan->id;
        $aciap->is_admin = $balasan->user->is_admin;

        event(new \App\Events\TerimaBalasan($aciap));

        $response = [
            'time' => $balasan->updated_at->format('d M h:i a'),
            'client_id' => $request->client_id
        ];

        return response()->json($response, 200);
    }

    public function get_ranting()
    {
        $ranting = \App\Ranting::all();
        return view('admin.ranting', compact(['ranting']));
    }

    public function post_ranting(Request $request)
    {
        $request->validate([
            'ranting' => 'required'
        ]);

        $data = new \App\Ranting;
        $data->name = ucwords(strtolower($request->ranting));
        $data->save();

        return redirect()->back()->with('informasi', [
            'type' => 'success',
            'value' => "Ranting $data->name berhasil ditambahkan"
        ]);
    }

    public function get_users()
    {
        $admins = \App\User::where(['is_admin' => 1])->get();
        $users = \App\User::where(['is_admin' => 0])->get();
        return view('admin.users', compact(['users','admins']));
    }
    
    public function post_usersup($id)
    {
        $akun = \App\User::where(['is_admin' => 0, 'id' => $id,])->whereNotNull('email_verified_at');
        if( $akun->count() != 1 )
            return redirect()->back()->with('informasi', [
                'type' => 'error',
                'value' => "Akun yang dipilih tidak tersedia"
            ]);

        $nama = $akun->get()->first()->name;
        event(new \App\Events\UserStateChanged($akun->get()->first()->remember_token, 'refresh'));

        $akun->update(['is_admin' => true]);


        return redirect()->back()->with('informasi', [
            'type' => 'success',
            'value' => "Akun {$nama} name telah menjadi admin"
        ]);
    }
    
    public function post_usersdown($id)
    {
        $akun = \App\User::where(['is_admin' => 1, 'id' => $id]);
        if( $akun->count() != 1 )
            return redirect()->back()->with('informasi', [
                'type' => 'error',
                'value' => "Akun yang dipilih bukan admin"
            ]);

        $nama = $akun->get()->first()->name;
        event(new \App\Events\UserStateChanged($akun->get()->first()->remember_token, 'refresh'));
        $akun->update(['is_admin' => false, 'jabatan' => null]);

        return redirect()->back()->with('informasi', [
            'type' => 'success',
            'value' => "Akun {$nama} telah menjadi akun biasa"
        ]);
    }

    public function post_jabatan(Request $request)
    {
        $request->validate([
            'jabatan' => 'required',
            'nama' => 'required'
        ]);

        switch ($request->jabatan) {
            case 'L':
                $jabatan = '[Lembaga]';
                break;

            case 'D':
                $jabatan = '[Departemen]';
                break;

            case 'B':
                $jabatan = '[Badan]';
                break;
            
            default:
                $jabatan = '';
                break;
        }

        $app = \App\User::find(auth()->user()->id);
        $app->jabatan = $jabatan . ucwords(strtolower($request->nama));
        $app->save();

        return response()->json(['status' => 'sukses'], 200);
    }

    public function get_broadcast()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/apps/" . config('onesignal.app_id'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                               'Authorization: Basic ' . config('onesignal.user_auth_key')));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
        $subscriber = curl_exec($ch);
        $subscriber = json_decode($subscriber)->players;
        curl_close($ch);

        $broadcast =\App\Broadcast::orderBy('updated_at', 'desc')->take(3)->get();
        return view('admin.broadcast', compact(['subscriber', 'broadcast']));
    }

    public function post_broadcast(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:broadcasts,title',
            'message' => 'required'
        ]);

        $isi = ucwords(strtolower($request->title));

        $pesan = new \App\Broadcast;
        $pesan->user_id = \Auth::user()->id;
        $pesan->title = htmlentities($isi);
        $pesan->message = $request->message;
        $pesan->slug = \Carbon\Carbon::now()->format('ymd') . '-'. \Str::slug($request->title) . '.html';
        $pesan->save();

        OneSignal::sendNotificationToAll(
            strip_tags(\Custom::limit($pesan->message, 30)), 
            $url = route('broadcast', $pesan->slug), 
            $data = null, 
            $buttons = null, 
            $schedule = null,
            $headings = strip_tags($isi)
        );

        return redirect()->back()->with('informasi', [
            'type' => 'success',
            'value' => "Pesan berhasil disebarkan pada : " . $pesan->created_at->format('d M h:i a')
        ]);
        
    }

}