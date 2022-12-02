<?php

for ($x = 1; $x < 5; $x++) {
    switch ($pid = pcntl_fork()) {
        case -1:
            die('�� ������� �������� �������� �������');
        case 0:
            doSmth();
        default:
            // ��� ������������� ��������
            pcntl_wait($status); // ������ ������ �������� "�����"-���������
            break;
    }
}

function doSmth()
{
    echo '������...';
}

//////////////////// ����������� ///////////////////////////

// ������� �������� �������
$child_pid = pcntl_fork();
if( $child_pid ) {
    // ������� �� �������������, ������������ � �������, ��������
    exit;
}
// ������ �������� ��������� ��������
// ����� ����� �� ���� ����� ������� �����
posix_setsid();

//////////////// ������� //////////////////////////

//����������
function sigHandler($signo) {
    switch($signo) {
        case SIGTERM: {
            // ����������� ������, ��� ������ ...
            break;
        }
        default: {
            //��� ��������� �������
        }
    }
}
//������������ ����������
pcntl_signal(SIGTERM, "sigHandler");

//////////// ��������� ������������ ������ /////////////////

// ��� ������ ���������� pid:
file_put_contents('/tmp/my_pid_file.pid', getmypid());

// ��� ������� ���������, ���� �� ����� ��:
function isDaemonActive($pid_file) {
    if (is_file($pid_file)) {
        $pid = file_get_contents($pid_file);
        //��������� �� ������� ��������
        if(posix_kill($pid,0)) {
            //����� ��� �������
            return true;
        } else {
            //pid-���� ����, �� �������� ���
            if(!unlink($pid_file)) {
                //�� ���� ���������� pid-����. ������
                exit(-1);
            }
        }
    }
    return false;
}

if (isDaemonActive('/tmp/my_pid_file.pid')) {
    echo 'Daemon already active';
    exit;
}

////////////////////////////////////
// ���� ������� ��� �������
$pids = array_filter(explode(
        "\n",
        shell_exec(
            'ps -A x | grep "'.dirname($_SERVER['SCRIPT_FILENAME'])
            .'/'. __FILE__ .'" | grep -v grep | grep -v sudo | grep -v null'
        ))
);

if(count($pids) > 1)
{
    die('end');
}