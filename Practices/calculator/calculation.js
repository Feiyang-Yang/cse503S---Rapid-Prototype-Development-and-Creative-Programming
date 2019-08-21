document.addEventListener("DOMContentLoaded",calculation, false);

function calculation(){
  const calAction = function(){
	let numFir = document.getElementById("firstNum").value;
  	let numSec = document.getElementById("secondNum").value;
	let firstNum = parseFloat(numFir);
	let secondNum = parseFloat(numSec);
	
	var operations = document.getElementsByName("operation");
	for(var i=0; i<operations.length; i++) {
    	operations[i].addEventListener("change", calculate, false);
	}
	var operation = null;
    for(var i=0; i<operations.length; i++){
        if(operations[i].checked){
            operation = operations[i].value;         
        }
    }

	
	let add = document.getElementById("add");
    let subtract = document.getElementById("subtract");
    let multiply = document.getElementById("multiply");
    let divide = document.getElementById("divide");
    
    let answer = 0;
    let output = document.getElementById("output");
    
    if(numFir=="" || numSec=="" || operation=="") {
        output.textContent = ("All fields fulfilled please!");
    } else if (add.checked) {
        answer = firstNum + secondNum;
        output.textContent = (answer); 
    } else if (subtract.checked) {
        answer = firstNum - secondNum;
        output.textContent = (answer); 
    } else if (multiply.checked) {
        answer = firstNum * secondNum;
        output.textContent = (answer); 
    } else if (divide.checked) {
    	if (numSec == 0){
    		output.textContent = "Cannot be divided by zero";
    	} else {
        	answer = firstNum / secondNum;
        	output.textContent = (answer); 
        }
    }
  }
  
document.getElementById("add").addEventListener("click", calAction, false);
document.getElementById("subtract").addEventListener("click", calAction, false);
document.getElementById("multiply").addEventListener("click", calAction, false);
document.getElementById("divide").addEventListener("click", calAction, false);

document.getElementById("firstNum").addEventListener("keyup", calAction, false);
document.getElementById("secondNum").addEventListener("keyup", calAction, false);

}