<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Destination;

class AssignEditorToDestination extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign:editor-destination';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign editor to destination';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $destination = Destination::first();
        $editor = User::where('role', 'editor')->first();
        
        if (!$editor) {
            $this->error('No editor found');
            return;
        }
        
        if (!$destination) {
            $this->error('No destination found');
            return;
        }
        
        $editor->destination_id = $destination->id;
        $editor->save();
        
        $this->info("Editor {$editor->name} assigned to destination {$destination->slug}");
    }
}
