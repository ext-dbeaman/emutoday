<?php

namespace Emutoday\Presenters;

use Laracasts\Presenter\Presenter;
use Carbon\Carbon;

class PagePresenter extends Presenter
{

    public function pageStatus()
    {
        $status = '';
        if($this->storys){
            if ($this->storys->count() >= $this->template_elements){
                $status = 'complete';
            } else if($this->storys->count() < $this->template_elements) {
                $status = 'incomplete';
            } else {
                $status =  'incomplete';
            }

        } else {
            $status = 'incomplete';
        }

        return $status;


    }
    public function pageScheduleStatus()
    {
        if ($this->start_date && $this->start_date->isFuture()) {
            return 'warning';
        } elseif ($this->start_date && $this->start_date->isPast() && $this->end_date && $this->end_date->isFuture()) {
            return 'danger';
        } elseif ($this->end_date && $this->end_date->isPast()) {
            return 'active';
        } else {
            return 'isproblem';
        }

    }
    public function pageLiveIn()
    {
        if ($this->start_date && $this->start_date->isFuture()) {
            return 'Starts in '. $this->start_date->diffForHumans(Carbon::now(),true);
        } elseif ($this->start_date && $this->start_date->isPast() && $this->end_date && $this->end_date->isFuture()) {
            return 'Ends in '. $this->end_date->diffForHumans(Carbon::now(),true);
        } elseif ($this->end_date && $this->end_date->isPast()) {
            return 'Ended ' .$this->end_date->diffForHumans();
        } else {
            return 'isproblem';
        }

    }

    public function prettyStartDate()
    {
        return $this->start_date->format('m-d-Y');
    }
    public function prettyEndDate()
    {
        return $this->end_date->format('m-d-Y');
    }


}
