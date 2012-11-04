<?php

class WallabyDateTime extends DateTime
{

	public function __toString()
	{
		return $this->format('M d, Y g:ia');
	}

}