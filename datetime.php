<?php
// Date and Time Format
date_default_timezone_set("Asia/Yangon");
$CurrentTime = time();
$DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
echo $DateTime;

