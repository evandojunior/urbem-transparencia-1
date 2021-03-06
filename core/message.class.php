<?php

class Message{

	private $message;
	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)){
			self::$instance = new Message();
		}
		return self::$instance;
	}
	
	public function count(){
		return count($this->message);
	}
	
	public function success($message){
		$_SESSION['message']['success'][] = $message;
	}
	
	public function error($message){
		$_SESSION['message']['error'][] = $message;
	}

	public function info($message){
		$_SESSION['message']['info'][] = $message;
	}

	public function question($message){
		$_SESSION['message']['question'][] = $message;
	}
	
	public function getSuccessMessages(){
		if(isset($_SESSION['message']) && $_SESSION['message']['success'] > 0){
			$messages = $_SESSION['message']['success'];
			
			if(isset($_SESSION['message']['success'])){
				unset($_SESSION['message']['success']);
			}

			return $messages;
		}
	}

	public function getErrorMessages(){
		if(isset($_SESSION['message']) && $_SESSION['message']['error'] > 0){
			$messages = $_SESSION['message']['error'];
			
			if(isset($_SESSION['message']['error'])){
				unset($_SESSION['message']['error']);
			}

			return $messages;
		}
	}	

	public function getInfoMessages(){
		if(isset($_SESSION['message']) && $_SESSION['message']['info'] > 0){
			$messages = $_SESSION['message']['info'];
			
			if(isset($_SESSION['message']['info'])){
				unset($_SESSION['message']['info']);
			}

			return $messages;
		}
	}

	public function getQuestionMessages(){
		if(isset($_SESSION['message']) && $_SESSION['message']['question'] > 0){
			$messages = $_SESSION['message']['question'];
			
			if(isset($_SESSION['message']['question'])){
				unset($_SESSION['message']['question']);
			}

			return $messages;
		}
	}

    public function showMessages(){
        $messages = $this->getInstance()->getSuccessMessages();
		if(count($messages)>0){
			foreach($messages as $message){ echo '<li class="success-message"><div class="success">'.$message.'</div></li>'; }
		}

		$messages = $this->getInstance()->getErrorMessages();
		if(count($messages)>0){
			foreach($messages as $message){ echo '<li class="error-message"><div class="error">'.$message.'</div></li>'; }
		}	

		$messages = $this->getInstance()->getInfoMessages();
		if(count($messages)>0){
			foreach($messages as $message){ echo '<li class="info-message">'.$message.'</li>'; }
		}

		$messages = $this->getInstance()->getQuestionMessages();
		if(count($messages)>0){
			foreach($messages as $message){ echo '<li class="question-message">'.$message.'</li>'; }
		}
    }
}
?>
