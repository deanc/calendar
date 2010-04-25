<?php

abstract class Calendar
{	
	protected $year;
	protected $month;
	protected $day;
	
	protected $timestamp;
	
	protected $daysInMonth;
	protected $firstDayOfMonth;
	
	protected $htmlBits = array();
	
	function __construct()
	{
		// defaults...
		if(empty($_REQUEST['year']) OR empty($_REQUEST['month']))
		{
			$this->year = date('Y');
			$this->month = date('n');
			$this->day = date('j');
		}	
		else
		{
			$this->year = intval($_REQUEST['year']);
			$this->month = intval($_REQUEST['month']);
			$this->day = intval($_REQUEST['day']);
		}
		
		// do some useful calculations
		$this->timestamp = gmmktime(0, 0, 0, $this->month, $this->day, $this->year);
		
		$this->daysInMonth = date('t', $this->timestamp);
		$this->firstDayOfMonth = date('w', gmmktime(0, 0, 0, $this->month, 1, $this->year));
	}
}

class MonthlyCalendar extends Calendar
{
	function __construct()
	{
		parent::__construct();
	}

	public function draw()
	{
		$html .= '<table class="calendar">';
		

		// headers
		$html .= '<thead><tr>';
		$days = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
		foreach($days AS $day)
		{
			$html .= '<th>' . $day . '</th>';
		}
		$html .= '</tr></thead>';
		
		// body
		$html .= '<tbody>';
		$c = 0;
		for($i = 1; $i <= 42; $i++)
		{
			$c++;
			if($i == 1)
			{
				$html .= '<tr>';
			}
			$html .= "\r\n<td>";
			if($i > $this->firstDayOfMonth AND ($i - $this->firstDayOfMonth) <= $this->daysInMonth)
			{
				$html .= $this->renderDay($i - $this->firstDayOfMonth);
			}
			else
			{
				$html .= '&nbsp;';
			}
			$html .= '</td>';
			if($c == 7)
			{
				$c = 0;
				if($i == 35)
				{
					$html .= '</tr>';
				}
				else
				{
					$html .= '</tr><tr>';
				}
			}		
		}
		$html .= '</tbody>';
		
		$html .= '</table>';
		return $html;
	}
	
	protected function renderDay($day)
	{
		return $day;
	}
}

?>