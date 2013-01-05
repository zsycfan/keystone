<?php

namespace Keystone\View\Renderer;
use Keystone\View\Renderer;

class Text extends Renderer
{
	public function render()
	{
		return file_get_contents($this->path());
	}
}