<?php

use rdx\fuelly\UnitConversion;
use rdx\units\Length;
use rdx\units\Mileage;
use rdx\units\Volume;

class OutputConversion extends UnitConversion {

	/**
	 *
	 */
	public function formatNumber( $number ) {
		return number_format($number, 2, $this->decimals, $this->thousands);
	}

	/**
	 *
	 */
	public function formatDistance( Length $distance ) {
		$distance = $distance->to($this->distance);
		return $this->formatNumber($distance) . ' ' . $this->distance;
	}

	/**
	 *
	 */
	public function formatVolume( Volume $volume ) {
		$volume = $volume->to($this->volume);
		return $this->formatNumber($volume) . ' ' . $this->volume;
	}

	/**
	 *
	 */
	public function formatMileage( Mileage $mileage ) {
		$mileage = $mileage->to($this->mileage);
		return $this->formatNumber($mileage) . ' ' . $this->mileage;
	}

}
