<?php

for ($x = 1; $x < 5; $x++) {
    switch ($pid = pcntl_fork()) {
        case -1:
            die('Не удалось породить дочерний процесс');
        case 0:
            doSmth();
        default:
            // Код родительского процесса
            pcntl_wait($status); // Защита против дочерних "Зомби"-процессов
            break;
    }
}

function doSmth()
{
    echo 'Делаем...';
}

//////////////////// Демонизация ///////////////////////////

// создаем дочерний процесс
$child_pid = pcntl_fork();
if( $child_pid ) {
    // выходим из родительского, привязанного к консоли, процесса
    exit;
}
// делаем основным процессом дочерний
// После этого он тоже может плодить детей
posix_setsid();

//////////////// Сигналы //////////////////////////

//Обработчик
function sigHandler($signo) {
    switch($signo) {
        case SIGTERM: {
            // Заканчиваем работу, как нибудь ...
            break;
        }
        default: {
            //все остальные сигналы
        }
    }
}
//регистрируем обработчик
pcntl_signal(SIGTERM, "sigHandler");

//////////// Поддержка уникальности демона /////////////////

// Где нибудь записываем pid:
file_put_contents('/tmp/my_pid_file.pid', getmypid());

// при запуске проверяем, есть ли такой же:
function isDaemonActive($pid_file) {
    if (is_file($pid_file)) {
        $pid = file_get_contents($pid_file);
        //проверяем на наличие процесса
        if(posix_kill($pid,0)) {
            //демон уже запущен
            return true;
        } else {
            //pid-файл есть, но процесса нет
            if(!unlink($pid_file)) {
                //не могу уничтожить pid-файл. ошибка
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
// Если процесс уже запущен
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