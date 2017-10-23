<?php namespace Model;

class TimeRange {
	private $id_timeRange;
	private $from;
	private $to;

	public function __construct($from, $to)	{
		$this->setFrom($from);
		$this->setTo($to);
	}

	public function getId() {
		return $this->id_timeRange;
	}

	public function getFrom() {
		return $this->from;
	}

	public function getTo() {
		return $this->to;
	}

	public function setId($value) {
		$this->id_timeRange = $value;
	}

	public function setFrom($value) {
		$this->from = $value;
	}

	public function setTo($value) {
		$this->to = $value;
	}

	public function toJson() {
    return [
			'id_timeRange' => $this->id_timeRange,
			'from' => $this->from,
			'to' => $this->to
		];
  }
} ?>
