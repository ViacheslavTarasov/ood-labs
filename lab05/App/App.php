<?php
declare(strict_types=1);

namespace Lab05\App;

use Lab05\App\Menu\ExitMenuCommand;
use Lab05\App\Menu\HelpMenuCommand;
use Lab05\App\Menu\InsertImageMenuCommand;
use Lab05\App\Menu\InsertParagraphMenuCommand;
use Lab05\App\Menu\ListMenuCommand;
use Lab05\App\Menu\RedoMenuCommand;
use Lab05\App\Menu\ReplaceTextMenuCommand;
use Lab05\App\Menu\ResizeImageMenuCommand;
use Lab05\App\Menu\SaveMenuCommand;
use Lab05\App\Menu\SetTitleMenuCommand;
use Lab05\App\Menu\UndoMenuCommand;
use Lab05\Document\Document;
use Lab05\Document\DocumentInterface;
use Lab05\Document\DocumentPrinter;
use Lab05\Document\DocumentSavingService;
use Lab05\Document\ImageManager;
use Lab05\History\History;
use Lab05\Menu\Menu;
use Lab05\Menu\MenuInterface;
use Lab05\Menu\MenuItem;
use Lab05\Service\FilesystemService;
use Lab05\Service\HtmlGenerationService;
use SplFileObject;

class App
{
    private const MAX_HISTORY_LENGTH = 10;
    /** @var MenuInterface */
    private $menu;
    /** @var DocumentInterface */
    private $document;
    /** @var SplFileObject */
    private $stdin;
    /** @var SplFileObject */
    private $stdout;

    public function __construct()
    {
        $this->stdin = new SplFileObject('php://stdin', 'r');
        $this->stdout = new SplFileObject('php://stdout', 'w');
        $history = new History(self::MAX_HISTORY_LENGTH);
        $filesystemService = new FilesystemService();
        $htmlGenerationService = new HtmlGenerationService();
        $imageManager = new ImageManager($filesystemService);
        $saveService = new DocumentSavingService($htmlGenerationService, $filesystemService);

        $this->document = new Document($history, $imageManager, $saveService);
        $this->menu = new Menu($this->stdin, $this->stdout);
    }

    public function run(): void
    {
        $this->initMenu();
        $this->menu->run();
    }

    private function initMenu(): void
    {
        $this->menu->addItem(new MenuItem('help', 'Show instructions', new HelpMenuCommand($this->menu)));
        $this->menu->addItem(new MenuItem('exit', 'Exit from program', new ExitMenuCommand($this->menu)));
        $this->menu->addItem(new MenuItem('setTitle', 'setTitle <title>', new SetTitleMenuCommand($this->document)));
        $this->menu->addItem(new MenuItem('insertParagraph', 'insertParagraph <position>|end <pagraph text>', new InsertParagraphMenuCommand($this->document)));
        $this->menu->addItem(new MenuItem('replaceText', 'replaceText <position> <pagraph text>', new ReplaceTextMenuCommand($this->document)));
        $this->menu->addItem(new MenuItem('insertImage', 'insertImage <position>|end <width> <height> <imagepath>', new InsertImageMenuCommand($this->document)));
        $this->menu->addItem(new MenuItem('resizeImage', 'resizeImage <position>|end <width> <height>', new ResizeImageMenuCommand($this->document)));
        $this->menu->addItem(new MenuItem('undo', 'Cancel prev command', new UndoMenuCommand($this->document)));
        $this->menu->addItem(new MenuItem('redo', 'Execute canceled command', new RedoMenuCommand($this->document)));
        $this->menu->addItem(new MenuItem('list', 'Output document items', new ListMenuCommand($this->document, new DocumentPrinter($this->stdout))));
        $this->menu->addItem(new MenuItem('save', 'save <path>', new SaveMenuCommand($this->document)));
    }
}