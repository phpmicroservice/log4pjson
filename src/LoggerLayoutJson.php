<?php

class LoggerLayoutJson extends \LoggerLayout
{

    /** Whether to include the event's location information (slow). */
    protected $locationInfo = false;

    /** Sets the location information flag. */
    public function setLocationInfo($value)
    {
        $this->setBoolean('locationInfo', $value);
    }

    /** Returns the location information flag. */
    public function getLocationInfo()
    {
        return $this->locationInfo;
    }

    public function format(\LoggerLoggingEvent $event)
    {
        // If required, initialize the location data
        if ($this->locationInfo) {
            $event->getLocationInformation();
        }

        $info = [
            'fqcn' => $event->getFullQualifiedClassname(),
            'level' => $event->getLevel(),
            'ndc' => $event->getNDC(),
            'message' => $event->getMessage(),
            'sname' => SERVICE_NAME,
            'addr' => APP_HOST_IP,
            'threadName' => $event->getThreadName(),
            'timeStamp' => $event->getTimeStamp(),
        ];
        if ($this->locationInfo) {
            $li = $event->getLocationInformation();
            $info['locationInfo'] =[
                'lineNumber'=>$li->getLineNumber(),
                'fileName'=>$li->getFileName(),
                'className'=>$li->getClassName(),
                'methodName'=>$li->getMethodName(),
                'fullInfo'=>$li->getFullInfo()
            ];

        }
        return json_encode($info) . PHP_EOL;
    }
}
