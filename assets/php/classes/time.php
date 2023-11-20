<?php 
    Class Time {
        function get_time($pasttime, $today = 0, $differenceFormat = '%y') {
            // Date variables
            $today = date("Y-m-d H:i:s");
            $datetime1 = date_create($pasttime);
            $datetime2 = date_create($today);

            // Find difference & interval between current date and post date (Years)
            $interval = date_diff($datetime1, $datetime2);
            $answerY = $interval->format($differenceFormat);

            // Difference in Months
            $differenceFormat = '%m';
            $answerM = $interval->format($differenceFormat);

            // Difference in Days
            $differenceFormat = '%d';
            $answerD = $interval->format($differenceFormat);

            // Difference in Hours
            $differenceFormat = '%h';
            $answerH = $interval->format($differenceFormat);

            // Check how much time has passed
            if($answerY >= 1) { // One year has passed
                $answerY = date(" F jS, Y ", strtotime($pasttime)); // . " at " . date("h:i:s a", strtotime($pasttime));
                return $answerY;
            } else if($answerM >= 1) { // One month has passed
                $answerM = date(" F jS, Y ", strtotime($pasttime)); // . " at " . date("h:i:s a", strtotime($pasttime));
                return $answerM;
            } else if($answerY >= 1) { // One year has passed
                $answerY = date(" F jS, Y ", strtotime($pasttime)); // . " at " . date("h:i:s a", strtotime($pasttime));
                return $answerY;
            } else if($answerD >= 1) { // 2+ days have passed
                $answerD = date(" F jS, Y ", strtotime($pasttime)); // . " at " . date("h:i:s a", strtotime($pasttime));
                return $answerD;
            } else if($answerD == 2) { // Two days have passed
                return $answerD . " d, " . $answerH . " hr ago"; // . " at " . date("h:i:s a", strtotime($pasttime));
            } else if($answerD == 1) { // One day has passed
                return "1 d, " . date("h:i:s a", strtotime($pasttime));
            } else { // Less than a day
                $differenceFormat = '%h';
                $answerH = $interval->format($differenceFormat);

                $differenceFormat = '%i';
                $answerI = $interval->format($differenceFormat);

                if(($answerH < 24) && ($answerH > 1)) { // Less than a day (24 hour)
                    return $answerH . " hr, " . $answerI . " min ago";
                } else if ($answerH == 1) { // 1 hour
                    return "an hour ago";
                } else { // Less than 1 hour
                    $differenceFormat = '%i';
                    $answerI = $interval->format($differenceFormat);

                    if(($answerI < 60) && ($answerI > 1)) { // Less than an hour (60 min)
                        return $answer . " minutes ago";
                    } else if($answerI == 1) { // One minute
                        return "a minute ago";
                    } else { // Less than a minute
                        $differenceFormat = '%s';
                        $answerS = $interval->format($differenceFormat);

                        if(($answerS < 60) && ($answerS > 10)) {
                            return $answer . " seconds ago";
                        } else if ($answerS < 10) {
                            return "few seconds ago";
                        }
                    }
                }
            }
        }
    }