<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Gui\Application;
use Gui\Components\Button;
use Illuminate\Filesystem\Filesystem;
use Nwidart\Modules\Facades\Module;

class VutaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vuta:run';

    protected $root = '';
    protected $appName = 'Laravel';
    protected $version = '1.0.0';
    protected $urlRepo = '';
    protected $filesystem = null;
    protected $processBar = null;

    protected $listCoreFolder = [
        'app',
        'bootstrap',
        'config',
        'database',
        'public',
        'resources',
        'routes',
        'storage',
        'tests',
    ];

    protected $listCoreFiles = [
        '.gitignore',
        '.env.example',
        '.styleci.yml',
        'artisan',
        'composer.json',
        'modules_statuses.json',
        'package.json',
        'phpunit.xml',
        'server.php',
        'webpack.mix.js',
    ];

    protected $availableModules = [];
    protected $listModules = [];
    protected $environments = [];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Vutatech Setup New Project');
        $this->initVariable();
        $this->setup();
        $this->processBar->finish();
        $this->line("");
        $this->info('Setup Complete.');
    }

    public function initVariable(){
        $this->root = __DIR__ . '/../../..';
        $this->filesystem = new Filesystem();
        $this->processBar = $this->output->createProgressBar(100);
        $this->processBar->start();
        $modules = Module::all();
        foreach($modules as $item){
            array_push($this->availableModules,$item->getName());
        }
    }

    public function setup(){
        $this->setupOnCli();
    }

    public function setupOnMac(){

    }

    public function setupOnWin(){
        $application = new Application([
            'title' => 'Vutatech Project Installer',
            'height' => 400,
        ]);

        $application->on('start', function () use ($application) {
            $window = $application->getWindow();
            $button = (new Button())
                ->setLeft(40)
                ->setTop(100)
                ->setWidth(200)
                ->setValue('SETUP PROJECT');

            $button->on('click', function () use ($button,$window) {
                $button->setValue('Look, I\'m a clicked button!');
                $window->setTitle('Clicked');
            });
        });

        $application->run();
    }

    public function setupOnCli(){
        
        // $this->listModules = $this->choice(
        //     'What is your name?',
        //     $this->availableModules,
        //     0,
        //     $maxAttempts = null,
        //     $allowMultipleSelections = true
        // );
        $this->processBar->setProgress(10);   
        $this->installModules();
        $this->installCore();
        $this->installEnv();
        $this->processBar->setProgress(100);   
    }

    public function installCore()
    {
        $this->line("");
        $this->info('Coping core file.....');
        // Copy all folder core
        foreach ($this->listCoreFiles as $coreFile) {
            if ($this->filesystem->exists($this->root . '/dist/' . $coreFile)) {
                $this->filesystem->delete($this->root . '/dist/' . $coreFile);
            }
            $this->filesystem->copy($this->root . '/' . $coreFile, $this->root . '/dist/' . $coreFile);
        }
        $this->processBar->setProgress(20);
        $this->line("");
        $this->info('Coping core folder....');
        foreach ($this->listCoreFolder as $coreFolder) {
            if ($this->filesystem->ensureDirectoryExists($this->root . '/dist/' . $coreFolder)) {
                $this->filesystem->deleteDirectory($this->root . '/dist/' . $coreFolder);
            }
            $this->filesystem->copyDirectory($this->root . '/' . $coreFolder, $this->root . '/dist/' . $coreFolder);
        }
        $this->line("");
        $this->processBar->setProgress(30);
    }

    public function installModules()
    {
        foreach ($this->listModules as $item) {
            if ($this->filesystem->ensureDirectoryExists($this->root . '/dist/Modules/' . $item)) {
                $this->filesystem->deleteDirectory($this->root . '/dist/Modules/' . $item);
            }
            $this->filesystem->copyDirectory($this->root . '/Modules/' . $item, $this->root . '/dist/Modules/' . $item);
        }
    }

    public function installEnv()
    {
        $environmentsRaw = file($this->root . '/.env.example');
        foreach ($environmentsRaw as $line) {
            if(!preg_match('/^?=?/',$line)){
                $this->line($line);
            }
        }
        // dd($this->getEnvValue('JWT_SECRET',$environments));
        // $this->filesystem->append($this->root . '/dist/.env', $environmentsRaw);
    }

    public function runSetupDB()
    {
    }

    public function runSetupRedis()
    {
    }

    public function runStartStream()
    {
    }

    public function runSetupQueue()
    {
    }

    public function setupCronTab()
    {
    }

    public function installNewModules()
    {
    }

    public function updateModule()
    {
    }

    public function removeModule()
    {
    }

    public function replaceEnvValue($key, $value)
    {
    }

    public function getEnvValue($key, $env)
    {
        $escaped = preg_quote('=' . env($key), '/');
        return "/^" . $key . "{$escaped}/m";
    }
}
