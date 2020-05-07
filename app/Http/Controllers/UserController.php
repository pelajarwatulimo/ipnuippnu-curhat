<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OneSignal;

class UserController extends Controller
{
    public function get_beranda(Request $request)
    {
        $curhatan = \App\Message::where(['user_id' => \Auth::user()->id])->get();
        return view('user.beranda', compact(['curhatan']));
    }

    public function get_pesan($id)
    {
        $pesan = \App\Message::where(['id' => $id, 'user_id' => auth()->user()->id])->first();
        
        \DB::table('message_answers')->where(['message_id' => $pesan->id])->update(['user_read' => 1]);

        return view('user.viewPesan', compact(['pesan']));
    }

    public function get_buatpesan()
    {
        return view('user.createPesan');
    }

    public function post_buatpesan(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'message' => 'required'
        ]);

        $buat = new \App\Message;
        $buat->title = ucwords(strtolower(strip_tags($request->title)));
        $buat->message = $request->message;
        $buat->user_id = \Auth::user()->id;
        
        if( !$buat->save() )
            return redirect()->back()->with('informasi', ['type'=>'error', 'value'=>'Gagal dalam menyimpan curhatan']);

        OneSignal::sendNotificationUsingTags(
            "{$buat->user->panggilan()} mengirim curhatan baru.",
            array(["field" => "tag", "key" => "isAdmin", "relation" => "=", "value" => config('app.key')]),
            $url = route('admin.beranda'),
            $data = null,
            $buttons = null,
            $schedule = null,
            $headings = "Curhatan Baru, Masuk!"
        );

        return redirect()->route('user.beranda')->with('informasi', ['type'=>'success', 'value'=>'Curhatan berhasil dikirim']);;

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
        $balasan->user_read = 1;
        $balasan->admin_read = 0;
        $balasan->message = $request->balasan;
        $balasan->message_id = $id;
        $balasan->save();

        $tujuan = \App\Message::find($id);

        OneSignal::async()->sendNotificationUsingTags(
            auth()->user()->panggilan() . " telah membalas curhatan.",
            array(["field" => "tag", "key" => "isAdmin", "relation" => "=", "value" => config('app.key')]),
            $url = route('admin.pesan', $id),
            $data = null,
            $buttons = null,
            $schedule = null,
            $headings = "Balasan Curhatan \"$tujuan->title\"!"
        );

        $aciap = new \stdClass;
        $aciap->id = $balasan->message_id;
        $aciap->name = $balasan->user->name;
        $aciap->avatar = $balasan->user->avatar ?: 'default.jpg';
        $aciap->message = app('profanityFilter')->filter($balasan->message);
        $aciap->created_at = $balasan->updated_at->format('d M h:i a');
        $aciap->kunci = $request->client_id;
        $aciap->answer_id = $balasan->id;
        $aciap->is_admin = $balasan->user->is_admin;

        event(new \App\Events\TerimaBalasan($aciap));

        $response = [
            'time' => $balasan->updated_at->format('d M h:i a'),
            'client_id' => $request->client_id,
            'message' => app('profanityFilter')->filter($balasan->message),
        ];

        return response()->json($response, 200);
    }

    public function post_read_pesan(Request $request)
    {
        $aciap = \App\MessageAnswer::find($request->answer_id);
        $aciap->user_read = 1;
        $aciap->save();

        return response()->json(['status' => 'Sukses'], 200);
    }


}
