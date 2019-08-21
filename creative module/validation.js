export const isEmpty = value => value.trim().length === 0;
export function showAlert(message,className){
    //create a div
    const div = document.createElement('div');
    //add classes
    div.className = `alert alert-${className}`;
    //add text
    div.appendChild(document.createTextNode(message));
    //get jumbortron
    const jumbotron = document.querySelector('#jumbotron');
    //get from div
    const form = document.querySelector('#form-div');
    //insert alert
    jumbotron.insertBefore(div,form);
    setTimeout(()=> document.querySelector('.alert').remove(),3000);
}