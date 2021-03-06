<?php

namespace Emutoday\Http\Controllers\Admin;


use Emutoday\Event;
use Illuminate\Http\Request;

use Emutoday\Http\Requests;

class EventController extends Controller
{

    protected $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {

    }
    public function queue(Event $event) {
        return view('admin.event.queue', compact('events'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function form(Event $event)
    {
        return view('admin.event.form', compact('event'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $event = $this->event->findOrFail($id);
        // $categories = \emutoday\Category::lists('category', 'id');

        return view('admin.event.form', compact('event'));
    }


}
