<?php

namespace Emutoday\Http\Controllers;

use Illuminate\Http\Request;

use Emutoday\Http\Requests;

use Emutoday\Story;
use Emutoday\Page;
use Emutoday\Announcement;
use Emutoday\Event;
use Emutoday\Tweet;
use Carbon\Carbon;
use JavaScript;

class MainController extends Controller
{
    protected $pages;
    //how many news stories and announcements to show on hub
    protected $recordLimitNews = 4;
    protected $recordLimitAnnouncements = 4;
    protected $recordLimitEvents = 4;
    protected $recordLimitHR = 3;

    public function __construct(Page $page, Story $story, Announcement $announcement, Event $event)

    {
        $this->page = $page;
        $this->story = $story;
        $this->announcement = $announcement;
        $this->event = $event;

    }

    public function index()
    {
        //Set current date time to begining of day and end of day
        $currentDateTimeStart = Carbon::now()->startOfDay();
        $currentDateTimeEnd = Carbon::now()->endOfDay();

        $page = $this->page->where([
            ['is_ready', 1],
            ['is_archived', 0],
            ['start_date', '<=', $currentDateTimeStart],
            ['end_date', '>=',  $currentDateTimeEnd]
        ])->first();

        //in case no new page has been set
        //pull last one to expire
        if(is_null($page)){
            $page = $this->page->where([
                ['is_ready', 1],
                ['is_archived', 0],
                ['start_date', '<=', $currentDateTimeStart]
            ])->first();

        }

        $currentStorysBasic = $this->story->where([
            ['story_type', 'news'],
            ['is_approved', 1],
            ['is_archived', 0],
            ['start_date', '<=', $currentDateTimeStart],
            ['priority', '>', 0]
            ])
            ->orderBy('priority','desc')
            ->orderBy('start_date','asc')
            ->take($this->recordLimitNews)->get();

            //make sure there are enough announcements with a priority over 0
            //if not requery with out priority limitation
        if($currentStorysBasic->count() < $this->recordLimitNews ){
            $currentStorysBasic = $this->story->where([
                ['story_type', 'news'],
                ['is_approved', 1],
                ['is_archived', 0],
                ['start_date', '<=', $currentDateTimeStart]
                ])
                ->orderBy('priority','desc')
                ->orderBy('start_date','asc')
                ->take($this->recordLimitNews)->get();
            }


        $currentAnnouncements = $this->announcement->where([
            ['is_approved', 1],
            ['is_archived', 0],
            ['type', 'general'],
            ['start_date', '<=', $currentDateTimeStart],
            ['end_date', '>=', $currentDateTimeEnd],
            ['priority', '>', 0]
        ])
        ->orderBy('priority','desc')
        ->orderBy('start_date','asc')
        ->take($this->recordLimitAnnouncements)->get();

        //make sure there are enough announcements with a priority over 0
        //if not requery with out priority limitation
        if($currentAnnouncements->count() < $this->recordLimitAnnouncements ){
            $currentAnnouncements = $this->announcement->where([
                ['is_approved', 1],
                ['is_archived', 0],
                ['type', 'general'],
                ['start_date', '<=', $currentDateTimeStart],
                ['end_date', '>=', $currentDateTimeEnd]
            ])
            ->orderBy('priority','desc')
            ->orderBy('start_date','asc')
            ->take($this->recordLimitAnnouncements)->get();
        }



        $events = $this->event->where([
            ['is_approved', 1],
            ['priority', '>', 0],
            ['end_date', '>=', $currentDateTimeStart]
        ])
        ->orderBy('priority','desc')
        ->orderBy('start_date','desc')
        ->take($this->recordLimitEvents)->get();

        $currentHRAnnouncements = $this->announcement->where([
            ['is_approved', 1],
            ['is_archived', 0],
            ['type', 'hr'],
            ['start_date', '<=', $currentDateTimeStart],
            ['end_date', '>=', $currentDateTimeEnd],
            ['priority', '>', 0]
        ])
        ->orderBy('priority','desc')
        ->orderBy('start_date','asc')
        ->take($this->recordLimitHR)->get();

        //make sure there are enough announcements with a priority over 0
        //if not requery with out priority limitation
        if($currentHRAnnouncements->count() < $this->recordLimitHR ){
            $currentHRAnnouncements = $this->announcement->where([
                ['is_approved', 1],
                ['is_archived', 0],
                ['type', 'hr'],
                ['start_date', '<=', $currentDateTimeStart],
                ['end_date', '>=', $currentDateTimeEnd]
            ])
            ->orderBy('priority','desc')
            ->orderBy('start_date','asc')
            ->take($this->recordLimitHR)->get();
        }




        // $currentAnnouncements = $this->announcement->where('is_approved', 1)->orderBy('priority','desc')->paginate(3);
        $barImgs = collect();
        $storys = $page->storys()->get();
        // dd($storys);
        foreach ($storys as $story) {
            if ($story->pivot->page_position === 0) {
                $heroImg = $story->storyImages()->where('image_type', 'front')->first();
            } else {
                $barImgs[$story->pivot->page_position] = $story->storyImages()->where('image_type', 'small')->first();
                // $barImgs->push( $story->storyImages()->where('image_type', 'imagesmall')->first() );
            }

        }
       //$events = $this->event->where(['start_date', '>=', $currentDateTime])->orderBy('start_date','desc')->get();
    //   $fakeDate = Carbon::now()->subYear();


        $storyImages = $page->storyImages;

        $tweets = Tweet::where('approved',1)->orderBy('created_at','desc')->take(4)->get();

        $allStorysWithVideoTag = Story::whereHas('tags', function ($query) {
            $query->where('name', 'video');
        })->where([
            ['is_approved',1],
            ['story_type', 'external'],
            ['start_date', '>=', Carbon::now()->startOfDay()]
        ])
        ->with('storyImages')->get();

        if(count($allStorysWithVideoTag)> 0) {
            $currentStoryWithVideoTag = $allStorysWithVideoTag->first();
            $currentStoryImageWithVideoTag = $currentStoryWithVideoTag->storyImages()->first();
        } else {
            $currentStoryImageWithVideoTag = null;
        }


        JavaScript::put([
            'jsis' => 'hi',
            'cdnow' => Carbon::now(),
            'cdstart' => Carbon::now()->subDays(7),
            'cdend' => Carbon::now()->addDays(7),
            'currentPage' => $page
        ]);
        return view('public.hub', compact('page', 'storyImages', 'heroImg', 'barImgs', 'currentStorysBasic', 'currentAnnouncements', 'events','tweets','currentStoryImageWithVideoTag','currentHRAnnouncements'));
        // return view('public.hub', compact('page', 'storyImages', 'heroImg', 'barImgs', 'currentStorysBasic', 'currentAnnouncements'));

    }

    public function main($story_type, $id)
    {
        $story = $this->story->findOrFail($id);
        $mainStoryImage =  $story->storyImages()->where('image_type', 'story')->first();

        $sideStorysFeatured = $this->story->where([
            ['story_type', 'story'],
            ['id', '<>', $id],
            ['is_approved', 1],
            ])
            ->orderBy('start_date', 'desc')
            ->orderBy('priority', 'desc')
            ->take(3)->get();

        // Remove All reference to Student until Further notice
        $sideStorysStudent = null;
        // $sideStorysStudent = $this->story->where([
        //     ['story_type', 'student'],
        //     ['id', '<>', $id],
        //     ['is_approved', 1],
        // ])->orderBy('created_at', 'desc')->take(3)->get();

        JavaScript::put([
            'jsis' => 'hi',
            'cdnow' => Carbon::now(),
            'cdstart' => Carbon::now()->subDays(7),
            'cdend' => Carbon::now()->addDays(7),
            'cstory' => $story
        ]);
        return view('public.story.story', compact('story','mainStoryImage', 'sideStorysFeatured', 'sideStorysStudent'));

    }


    public function search(Request $request)
    {
        $searchTerm =  $request->input('searchterm');
        $searhTermWild = $searchTerm  . '*';
        $searchStoryResults = Story::search($searhTermWild, false)->select('title','subtitle','story_type','teaser','id')->paginate(10);
        $searchEventResults = Event::search($searhTermWild, false)->select('title','description','submitter','id')->paginate(10);
        $searchAnnouncementResults = Announcement::search($searhTermWild, false)->select('title','announcement','submitter','id')->paginate(10);



        return view('public.searchresults', compact('searchTerm', 'searchStoryResults','searchEventResults','searchAnnouncementResults'));
    }
}
