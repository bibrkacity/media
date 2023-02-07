<?php

namespace  App\Services;

use App\Models\Citation;
use App\Models\Messenger;

class CitationService
{
    public static function index_web( int $per_page )
    {
        return Citation::orderBy('id','desc')
            ->paginate($per_page);
    }

    public static function index_api(int $page,  int $per_page ): array
    {
        $result = Citation::orderBy('id','desc')
            ->offset(($page-1)*$per_page)
            ->limit($per_page)
            ->get();

        $citations = [];

        foreach($result as $one){
            $citation = new \stdClass();
            $citation->id = $one->id;
            $citation->citation = $one->citation;
            $citation->created_at = $one->created_at;

            $user = new \stdClass();
            $user->id = $citation->User->id;
            $user->name = $citation->User->name;
            $citation->User = $user;

            $citation->sent_count = $citation->Messengers ? count($citation->Messengers) : 0;

            $citations[] = $citation;
        }

        return $citations;
    }

    public static function send_form( $citation_id , $messengers )
    {
        $data = ['citation_id'=>$citation_id,
            'messengers' => $messengers
        ];

        return view('citations.send', $data)->render();

    }

    public static function messengers() : array
    {
        $data = [];
        $data[] = ['', '-select messenger-'];

        foreach(Messenger::all() as $one ){
            $data[] = [$one->name, $one->display_name];
        }
        return $data;
    }
}
