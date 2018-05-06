<?php
return array(
    'path' => './data/logs',
    'format' => '%timestamp% %priorityName% (%priority%): %message%',
    'file_name' => date('d_m_Y'),
    'enable' =>  true,
);