@servers(['remote' => ['ayesha@192.168.0.102']])


@setup
    $pythonScriptPath = '/home/ayesha/sample.py';
 @endsetup
@task('python_script', ['on' => 'remote'])
python3 {{ $pythonScriptPath }}
@endtask 
