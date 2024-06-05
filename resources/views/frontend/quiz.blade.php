@extends('frontend.include.layout1')
<style>
.ysquiz{
  	width: 80%;
    text-align: left;
    padding: 25px;
}
.ysquiz .ysquiz-header h1 {
  margin: 0;
  border-bottom: 1px solid #000000;
}
.ysquiz .ysquiz-content .ysquiz-question .ysquiz-question-title {
	border-bottom: 1px solid #2678c0;
	margin-bottom: 25px;
	color: #2678c0;
}
.ysquiz .ysquiz-content .ysquiz-question ul {
  padding: 15px;
  list-style: none;
}
.ysquiz-question label{
	color: #2778c1;
	cursor: pointer;
}
.ysquiz-question label input{
	display: inline-block;
    width: 20px;
    height: 20px;
    margin: 10px;
    cursor: pointer;
}
.ysquiz .ysquiz-content .ysquiz-question button {
    width: auto;
    background: #2678c0;
    font-weight: bold;
    color: rgba(255, 255, 255, 0.8);
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 23px;
    margin: 10px 30px;
    min-width: 110px;
}
.ysquiz .ysquiz-content .ysquiz-question button:hover {
  box-shadow: 0 0 0 2px white, 0 0 0 3px skyblue;
}
.ysquiz .ysquiz-content .ysquiz-result {
  text-align: center;
}
</style>
@section('sub-content')
@if($user->user_status == 'approved')
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<h2 class="my-heading" style="margin-left: 25px;margin-top: 25px;"><strong>Eligibility Test</strong></h2>
    	<div class="ysquiz"></div>
	</div>
</div>
@else
<div class="row">
	
	<div class="col-lg-12 col-md-12 col-sm-12">
		<br />
		<div class="alert alert-warning" role="alert">
		  	<span><b>Note:</b> You can not access induction & quiz tab untill your account is approved.</span>
		</div>
		
	</div>
</div>
@endif
@endsection
@section('script')

@if($user->user_status == 'approved')
<script src="{{asset('public/plugins/ysquiz/ysquiz.js')}}"></script>
<script>
	$(document).ready(function(){
	    var myQuestions = [{
	      question: "What is the sixth month of the year?",
	      answers: ["July", "August", "May", "April"],
	      correct: "June"
	    }, {
	      question: "Fill in the missing number: 24, 31, 38, 45, 52, ?",
	      answers: ["54", "23", "65", "44"],
	      correct: "59"
	    }, {
	      question: "Which of the dates below is the latest?",
	      answers: ["February 20, 1992", "June 14, 1929", "May 31, 1992", "June 6, 1929"],
	      correct: "October 14, 1992"
	    }, {
	      question: "A clock lost 2 minutes and 20 seconds in 40 days. How many seconds did it lose per day?",
	      answers: ["1.5", "2", "2.5", "3"],
	      correct: "3.5"
	    }, {
	      question: "Which of the numbers below is the smallest?",
	      answers: [".061", ".0161", ".0061", "0.116"],
	      correct: "0.0016"
	    }, {
	      question: "The total cost of 7 pears is 12.50. How much will 11 pears cost?",
	      answers: ["$20.40", "$18.30", "$16.90", "$20.20"],
	      correct: "$19.60"
	    }, {
	      question: "A pool is 10 feet long and 5 feet wide. How many feet deep is the pool if it holds 300 cubic feet of water?",
	      answers: ["9", "16", "3", "11"],
	      correct: "6"
	    }, {
	      question: "Fill in the missing number: 23, 26, 20, 23, 17, ?",
	      answers: ["23", "26", "14", "13"],
	      correct: "20"
	    }, {
	      question: "Over 14 days Joe saved $42. What was his average daily savings?",
	      answers: ["$5.00", "$6.00", "$2.50", "$3.50"],
	      correct: "$3.00"
	    }, {
	      question: "Which of the dates below is the earliest?",
	      answers: ["June 6, 1996", "July 9, 1969", "February 27, 1996", "July 9, 1999"],
	      correct: "June 9, 1969"
	    }, {
	      question: "Which of the numbers below is the smallest?",
	      answers: ["7", "9", "1", "10"],
	      correct: ".61"
	    }, {
	      question: "A test has 30 questions. If Tom gets 70% correct, how many questions did Tom get wrong?",
	      answers: ["7", "8", "10", "6"],
	      correct: "9"
	    }];

	    var myQuiz = new ysQuiz(myQuestions);
	    
	});
</script>
@endif

@endsection