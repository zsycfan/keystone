<?php

namespace Keystone\View\Renderer;
use Keystone\View\Renderer;

class Php extends Renderer
{
	public function render()
	{
		return \Laravel\View::make('path: '.$this->path())->with($this->data())->render();
	}
}