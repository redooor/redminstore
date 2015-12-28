<?php namespace Redooor\Redminstore\Test;

use Redooor\Redminstore\App\Models\UI\Menu;

class UIMenuModelTest extends RedminTestCase
{
    public function testGetAllPagesNoPageFound()
    {
        $pages = Menu::getPages();

        $this->assertTrue(count($pages) == 0);
    }
}
