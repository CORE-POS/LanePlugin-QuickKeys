<?php

use COREPOS\pos\lib\FormLib;

class Test extends PHPUnit_Framework_TestCase
{
    public function testPlugin()
    {
        $obj = new QuickKeys();
    }

    public function testParser()
    {
        $p = new QuickKeyLauncher();
        $this->assertEquals(true, $p->check('QK1'));
        $this->assertEquals(true, $p->check('QO1'));
        $this->assertEquals(false, $p->check('Foo'));

        $p->check('100QK1');
        $json = $p->parse('100QK1');
        $this->assertNotEquals(false, strstr($json['main_frame'], 'QKDisplay'));

        $p->check('QO1');
        $json = $p->parse('QO1');
        $this->assertNotEquals(0, strlen($json['output']));
    }

    public function testPages()
    {
        $page = new QKDisplay();
        $this->assertEquals(true, $page->preprocess());
        FormLib::set('quickkey_submit', 'foo');
        $this->assertEquals(false, $page->preprocess());
        FormLib::set('quickkey_submit', 'QK1');
        FormLib::set(md5('QK1'), 'QK1');
        CoreLocal::set('qkInput', '');
        $this->assertEquals(true, $page->preprocess());
    }
}

