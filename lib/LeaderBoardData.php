<?php

class LeaderBoardData
{
    /** @var array */
    private $json;
    /** @var int */
    public $maxDay = 0;

    /** @var int */
    public $leaderBoardId;
    /** @var int */
    public $year;

    /** @var string */
    private $session;

    /**
     * @param int $year
     * @return array
     */
    private function loadJson(int $leaderBoardId, int $year)
    {
        $cacheFile = __DIR__ . '/../cache/' . $leaderBoardId . '-' . $year . '.json';
        if (file_exists($cacheFile) && filemtime($cacheFile) > time() - 300) {
            return json_decode(file_get_contents($cacheFile), true);
        } else {
            $opts = array(
                'http' => array(
                    'method' => "GET",
                    'header' => "Accept-language: en\r\n" .
                        "Cookie: session={$this->session}\r\n"
                )
            );

            $context = stream_context_create($opts);
            // Open the file using the HTTP headers set above
            $data = file_get_contents("http://adventofcode.com/{$this->year}/leaderboard/private/view/{$this->leaderBoardId}.json",
                false, $context);
            $json = json_decode($data, true);
            if (!$json) {
                die('Unable to get json from AoC. Please check your session cookie value in config/session.txt.');
            }
            file_put_contents($cacheFile, $data);
            return json_decode($data, true);
        }
    }

    /**
     * LeaderBoardData constructor.
     * @param int $leaderBoardId
     * @param int $year
     */
    public function __construct(int $leaderBoardId, int $year)
    {
        if (file_exists(__DIR__ . '/../config/session.txt')) {
            $this->session = file_get_contents(__DIR__ . '/../config/session.txt');
        } else {
            die('config/session.txt with a valid AoC session cookie value is required.');
        }
        
        $this->leaderBoardId = $leaderBoardId;
        $this->year = $year;
        $this->json = $this->loadJson($leaderBoardId, $year);
    }

    /**
     * @return array[]
     */
    public function getDays()
    {
        $days = [];

        foreach ($this->json['members'] as $memberId => $member) {
            foreach ($member['completion_day_level'] as $day => $dayData) {
                $dayStart = (new DateTime("{$this->json['event']}-12-{$day} 05:00:00", new DateTimeZone('UTC')))->getTimestamp();
                if ($day > $this->maxDay) $this->maxDay = $day;
                if (!isset($days[$day])) {
                    $days[$day] = [];
                }

                $md = [
                    'name' => $member['name'] ?? $memberId,
                    'day' => $day,
                    'part1' => null,
                    'part2' => null,
                    'part2Diff' => null,
                ];
                if (isset($dayData[1])) {
                    $md['part1'] = (new DateTime($dayData[1]['get_star_ts']))->getTimestamp() - $dayStart;
                }
                if (isset($dayData[2])) {
                    $md['part2'] = (new DateTime($dayData[2]['get_star_ts']))->getTimestamp() - $dayStart;
                    $md['part2Diff'] = $md['part2'] - $md['part1'];
                }

                $days[$day][$memberId] = $md;
            }
        }
        return $days;
    }

    /**
     * @param int $day
     * @return array
     */
    public function getDay(int $day)
    {
        return $this->getDays()[$day] ?? [];
    }

    /**
     * @return array
     */
    public function getTotals()
    {
        $totals = [];
        foreach ($this->getDays() as $day => $dayMembers) {
            foreach ($dayMembers as $dayMemberId => $dayMemberData) {
                if (!isset($totals[$dayMemberId])) {
                    $totals[$dayMemberId] = [
                        'name' => $dayMemberData['name'],
                        'part1Total' => 0,
                        'part1Avg' => 0,
                        'part2Total' => 0,
                        'part2Avg' => 0,
                        'part2DiffTotal' => 0,
                        'part2DiffCount' => 0,
                        'part2DiffAvg' => 0,
                        'penalty' => 0
                    ];
                }

                //if ($dayMemberData['part2Diff'] > 7200) continue;
                if ($dayMemberData['part2Diff'] > 7200) {
                    $dayMemberData['part2Diff'] = 7200;
                    $totals[$dayMemberId]['penalty']++;
                }
                $totals[$dayMemberId]['part2DiffTotal'] += $dayMemberData['part2Diff'] ?? 0;
                $totals[$dayMemberId]['part2DiffCount'] += $dayMemberData['part2'] ? 1 : 0;
                $totals[$dayMemberId]['part1Total'] += $dayMemberData['part1'] ?? 0;
                $totals[$dayMemberId]['part2Total'] += $dayMemberData['part2'] ?? 0;

                if ($totals[$dayMemberId]['part2DiffCount'] > 0) {
                    $totals[$dayMemberId]['part2DiffAvg'] = floor($totals[$dayMemberId]['part2DiffTotal'] / $totals[$dayMemberId]['part2DiffCount']);
                    $totals[$dayMemberId]['part1Avg'] = floor($totals[$dayMemberId]['part1Total'] / $totals[$dayMemberId]['part2DiffCount']);
                    $totals[$dayMemberId]['part2Avg'] = floor($totals[$dayMemberId]['part2Total'] / $totals[$dayMemberId]['part2DiffCount']);
                }
            }
        }

        return $totals;
    }

    /**
     *
     */
    public function getTopLists()
    {
        $top = [];

        foreach ($this->getDays() as $day => $dayMembers) {
            foreach ($dayMembers as $dayMemberId => $dayMemberData) {
                $top[] = [
                    'day' => $day,
                    'name' => $dayMemberData['name'],
                    'part2Diff' => $dayMemberData['part2Diff'],
                    'part1' => $dayMemberData['part1'],
                    'part2' => $dayMemberData['part2']
                ];
            }
        }

        return $top;
    }

    /**
     * @param int $timestamp
     * @return string
     */
    public static function readableTimestamp($timestamp)
    {
        if (is_null($timestamp)) {
            return "";
        }
        $hours = floor($timestamp / 3600);
        $minutes = floor(($timestamp / 60) % 60);
        $seconds = $timestamp % 60;

        $str = str_pad($seconds, 2, '0', STR_PAD_LEFT);
        if ($minutes || $hours) {
            $str = str_pad($minutes, 2, '0', STR_PAD_LEFT) . ':' . $str;
        }
        if ($hours) {
            $str = str_pad($hours, 2, '0', STR_PAD_LEFT) . ':' . $str;
        }
        return $str;
    }
}
