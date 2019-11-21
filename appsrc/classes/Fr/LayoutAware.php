<?php
namespace Fr;

interface LayoutAware
{
    
    public function prepareLayout();
    public function renderLayout($content);
    
}
