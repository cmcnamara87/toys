<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['year', 'item_id', 'title', 'gallery_url', 'gallery_plus_url', 'view_item_url', 'currency_id', 'currency_value', 'time_left', 'start_time', 'end_time'];

    public function getDates()
    {
        return array('created_at', 'updated_at', 'start_time', 'end_time');
    }

    public function getPrettyTitle() {
        $words = [
//            'star trek',
            'vintage',
            'collectible',
        ];
        $title = strtolower($this->title);
        foreach($words as $word) {
            $title = str_replace($word, '', $title);
        }
        return ucwords($title);
    }

    public function endsIn() {
        $ts = $this->end_time;
        if(!ctype_digit($ts))
            $ts = strtotime($ts);

        $diff = time() - $ts;
        if($diff == 0)
            return 'now';
        elseif($diff > 0)
        {
            $day_diff = floor($diff / 86400);
            if($day_diff == 0)
            {
                if($diff < 60) return 'just now';
                if($diff < 120) return '1 minute ago';
                if($diff < 3600) return floor($diff / 60) . ' minutes ago';
                if($diff < 7200) return '1 hour ago';
                if($diff < 86400) return floor($diff / 3600) . ' hours ago';
            }
            if($day_diff == 1) return 'Yesterday';
            if($day_diff < 7) return $day_diff . ' days ago';
            if($day_diff < 31) return ceil($day_diff / 7) . ' weeks ago';
            if($day_diff < 60) return 'last month';
            return date('F Y', $ts);
        }
        else
        {
            $diff = abs($diff);
            $day_diff = floor($diff / 86400);
            if($day_diff == 0)
            {
                if($diff < 120) return 'in a minute';
                if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';
                if($diff < 7200) return 'in an hour';
                if($diff < 86400) return 'in ' . floor($diff / 3600) . ' hours';
            }
            if($day_diff == 1) return 'Tomorrow';
            if($day_diff < 4) return date('l', $ts);
            if($day_diff < 7 + (7 - date('w'))) return 'next week';
            if(ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';
            if(date('n', $ts) == date('n') + 1) return 'next month';
            return date('F Y', $ts);
        }
    }
    
    public function getFacts() {
        $facts = [];
        if(strpos(strtolower($this->title), "mego") !== false) {
            $facts[] = "In 1971, Mego created the very first 8\" action figure.";
            $facts[] = "In 1975, Mego started selling Star Trek action figures and toys.";
            $facts[] = "Fourteen figures in three \"waves\" were released by Mego between 1975 and 1978.";
            $facts[] = "The Romulan and Andorian from Wave Three considered to be the rarest of all.";
            if(strpos(strtolower($this->title), "20") !== false) {
                $facts[] = "In 2007, EMCE Toys released reproductions of many of Mego's 8-inch Star Trek figures.";
            }
            if(strpos(strtolower($this->title), "klingon") !== false) {
                $facts[] = "The Klingon, with belt, phaser and communicator, is part of Wave One.";
            }
        }
        if(strpos(strtolower($this->title), "skybox") !== false) {
            $facts[] = "Skybox produced Star Trek trading cards from 1991 to 2000.";
        }
        if(strpos(strtolower($this->title), "hallmark") !== false) {
            $facts[] = "Hallmark has produced licensed \"Keepsake\" Christmas ornaments since 1991.";
            $facts[] = "Hallmark Ornaments can be see in two Voyager episodes.";
            $facts[] = "Hallmark Ornaments depict Star Trek characters, ships, props, artwork, and scenes.";
            $facts[] = "Hallmark has frequently used recorded music and clips of Star Trek actors.";
        }
        if(strpos(strtolower($this->title), "playmates") !== false) {
            $facts[] = "Playmates Toys produced a lot of Star Trek items, starting in 1991.";
            $facts[] = "Playmates action figures have appeared in two Big Bang Theory episodes.";
        }
        if(strpos(strtolower($this->title), "hamilton") !== false) {
            $facts[] = "The Hamilton Collection started producing Star Trek items in 1973.";
            $facts[] = "Some Hamilton plates contain 24K gold and platinum detailing.";
        }
        if(strpos(strtolower($this->title), "plate") !== false) {
            $facts[] = "The porcelain plates were produced in limited editions.";
        }
        if(strpos(strtolower($this->title), "micro") !== false) {
            $facts[] = "Star Trek Micro Machines were produced by Galoob from 1993 to 1997.";
            $facts[] = "52 unique molds were created for the Micro Machines Star Trek line.";
        }
        if(strpos(strtolower($this->title), "applause") !== false) {
            $facts[] = "Applause produced a large number of Star Trek collectibles during the 1990s.";
            $facts[] = "Applause produced many figures, statues, dioramas, and other Star Trek collectibles.";
        }
        if(strpos(strtolower($this->title), "star trek ii ") !== false) {
            $facts[] = "Star Trek II: The Wrath of Khan was released 4 June 1982.";
        }
        if(strpos(strtolower($this->title), "star trek iii") !== false) {
            $facts[] = "Star Trek III: The Search for Spock was released 1 June 1984.";
        }

        if(2016 - $this->year > 10) {
            $age = 2016 - $this->year;
            $facts[] = "It was originally released in {$this->year}, making it {$age} years old.";
        }
        shuffle($facts);
        return array_slice($facts, 0, min(3, count($facts)));
    }

    public function cluster()
    {
        return $this->belongsTo(Cluster::class);
    }

}
