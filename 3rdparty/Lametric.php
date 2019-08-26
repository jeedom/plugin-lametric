<?php
class Lametric2
{
    /**
     * The local Ip to LaMetric
     *
     * @var string
     */
	private $_localIp = null;

    /**
     * Access token for application
     *
     * @var string
     */
	private $_token = null;

    /**
     * Icon number from LaMetric gallery
     *
     * @var mixed
     */
	private $_icon = null;

    /**
     * Sound number from LaMetric
     *
     * @var string
     */
    private $_sound = null;
    
    /**
     * A list of HTTP headers required for authorization
     * 
     * @var array
     */
	private $_http_headers = array();

    /**
     * Array for storing frames
     * 
     * @var array
     */
    private $_frames = array();

    /**
    * Constructor method
    * 
    * @param    array  $config   Set pushUrl and token variables
    * @return   void
    */
	public function __construct($config=null)
	{
        if(!is_null($config)) {
            $this->setPushURL($config['pushURL']);
            $this->setToken($config['token']);
 
            $this->_http_headers = array(
                'Accept: application/json',
                'Authorization: Basic '.$this->_token,
                'Pragma: no-cache',
            );

        }
	}

    /**
    * Set icon for notification
    * 
    * @param    integer  $code    Integer with icon number from gallery
    * @return   void
    */
    public function setIcon($code)
    {
        $this->_icon = $code;
    }

    
    /**
    * Set sound for notification
    * 
    * @param    integer  $code    Integer with sound name from gallery
    * @return   void
    */
    public function setSound($code)
    {
        $this->_sound = $code;
    }


    /**
    * Set local IP for API calls
    * 
    * @param    string  $localIp    String with localIp of the LaMetric
    * @return   void
    */
    public function setLocalIp($localIp)
    {
        $this->_localIp = $localIp;
    }

    /**
    * Set token API calls
    * 
    * @param    string  $token    String with application token
    * @return   void
    */
    public function setToken($token)
    {
        $this->_token = $token;
    }

    /**
    * Add frame to global frames array
    * 
    * @param    string  $text    String with desired push notification
    * @param    number  $icon    Icon ID used for push notification
    * @return   void
    */
    public function addFrame($text, $icon)
    {
        if(empty($text)) {
            throw new LametricException('Missing data in frame parameters.');
        }

       array_push($this->_frames, array($text, empty($icon) ? $this->_icon : $icon));
    }

    /**
    * Add frames to global frames array
    * 
    * @param    mixed  $frames    Array with text and icon pairs
    * @return   void
    */
    public function addFrames($frames)
    {
        foreach($frames as $frame) {

            if(empty($frame['text'])) {
                throw new LametricException('Missing data in frame parameters.');
            }

            $this->addFrame($frame['text'], empty($frame['icon']) ? $this->_icon : $frame['icon']);
        }  
    }

     /**
    * Set local IP for API calls
    * 
    * @return   void
    */
    public function generatePushUrl()
    {
        return "http://".$this->_localIp.":8080/api/v2/device/notifications";
    }


    /**
    * Generate global frames array
    * 
    * @param    boolean  $json    Return data as JSON (true)    
    * @return   string|array
    */
    public function generateData($json=false)
    {
        if(empty($this->_frames)) throw new LametricException('There is no data to generate.');

        $frames = array('frames'=>array());

       foreach($this->_frames as $key=>$frame) {
            array_push($frames['frames'], array('index'=>$key, 'text'=>$frame[0], 'icon'=>empty($frame[1]) ? $this->_icon : 'i'.$frame[1]));
       }
       $data->model->frames = $frames;

        if(in_array(array("alarm1","alarm2","alarm3","alarm4","alarm5","alarm6","alarm7","alarm8","alarm9","alarm10","alarm11","alarm12","alarm13"),$this->_sound)) {
            $data->sound->category = "alarms";
            $data->sound->id = $this->_sound;
        } elseif (!empty($this->_sound)){
            $data->sound->category = "notifications";
            $data->sound->id = $this->_sound;
        }

       return (!$json) ? $data : json_encode($data);
    }

    /**
    * Clear frames array
    * 
    * @return   void
    */
    public function clearFrames()
    {
        unset($this->_frames);
        $this->_frames = array();
    } 

    /**
    * Send push notification
    * 
    * @param    mixed  $text    String with desired push notification
    * @param    number  $icon    Icon ID used for push notification
    * @throws   Lametric\Exception           If push notification cannot be sent
    */

    public function push($text = null, $icon = null)
    {
        if(empty($this.generatePushUrl()) || empty($this->_token)) {
            throw new LametricException('Config needs to be set.');
        } elseif(empty($this->_frames) && is_null($text)) {
             throw new LametricException('Empty frames array.');
        } elseif(is_array($text)) {
            $this->addFrames($text);
            $data_string = json_encode($this->generateData());
            $this->clearFrames();
        } elseif(is_null($text)) { 
            $data_string = json_encode($this->generateData());
        } else {
            
            if(empty($this->_frames)) {
                $data_string = json_encode(array(
                        'frames'=>
                        array(
                            array('index'=>0,
                                'text'=>$text,
                                'icon'=>(is_null($icon)) ? $this->_icon : $icon,
                            ))));
            } else {
                $data_string = json_encode(array(
                        'frames'=>
                        array(array($this->_frames)))); 
            }          
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->generatePushUrl());
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->_http_headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $result = json_decode(curl_exec($ch));

        if(isset($result->error) && $result->error) {
            throw new LametricException($result->error->message . ' - '. $result->error->trace[0]);
        }
    }
}