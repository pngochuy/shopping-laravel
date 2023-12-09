<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function rate(Request $request)
    {
        $data = $request->all();

        $rate = Rate::where("userID", $data["userID"])
            ->where("blogID", $data["blogID"])
            ->first();

        if ($rate) {
            // update rate
            if ($rate->update($data)) {
                // echo $rate;
                $output = $this->getRate($rate);

                echo $output;
            } else {
                echo "Updated rate error!";
            }
        } else {
            // echo "rate not found";
            if (Rate::create($data)) {
                echo "created successfully";
            } else {
                echo "create failed";
            }
        }
    }

    public function getRate($rate)
    {
        $rateScore = $rate->rate;

        // ratings_over
        $output = '<div class="vote">';

        for ($i = 1; $i <= 5; $i++) {
            $rating_over = "";
            if ($i <= $rateScore) {
                $rating_over = "ratings_over";
            }

            $output .= '<div class="star_' . $i . ' '  . ' ratings_stars ' . $rating_over . '" ><input value="' . $i . '" type="hidden"></div>';
        }

        $output .= '<span class="rate-np">100   </span>
                    </div>';
        return $output;
    }
}
