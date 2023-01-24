

let loadFile = function(event, obj) {
    let output = document.getElementById(obj.name);
    output.src = URL.createObjectURL(event.target.files[0]);
}



function checkValues(array) {
    let value = true;

    for (var i = 0; i < array.length; i++) {
        if(array[i].value == "") {
            value = false;
            break;                  
        }
    }

    return value;
}



function createQuestion(obj) {
   let parent = obj.parentElement;
   let questions = document.querySelectorAll('.questions');
   let count = questions.length + 1; 
   
   if (checkValues(parent.querySelectorAll('input[type="text"]'))) {
        let div = document.createElement('div');

        addQuestionInner(div, questions.length);

        parent.insertBefore(div, obj);

        if(count == 2) {
            parent.querySelector('#removeQuest').style.display = 'inline-block';
        }     

    } else {
        let errorAlert = document.createElement('div');
        errorAlert.className = "alert alert-danger mt-2 alert-dismissible fade show";
        errorAlert.innerHTML =  "Поля вопроса и все поля ответов должны быть заполнены" + 
                         "<div  class='btn-close' data-bs-dismiss='alert' aria-label='Close'></div>";
        parent.appendChild(errorAlert);
    }
}

function removeQuestion(obj) {
    let questions = document.querySelectorAll('.questions');
    let count = questions.length - 1;
    questions[questions.length - 1].remove();  

    if (count == 1) {
        obj.style.display = 'none';
    }  
}

function addQuestionInner(elem, count) {
    elem.innerHTML = "<div class='questions d-flex justify-content-center flex-wrap'>" +                        
                        "<div class='question_image d-flex flex-column justify-content-center text-center p-2'>" + 
                            "<label>Картинка вопроса</label>" +  
                            "<div class='questions_" + count + "_image' style='color: red'></div> "  +                
                            "<img  id='questions[" + count + "][image]' class='output'>" + 
                            
                            "<div class='form__input-file mt-2'>" + 
                                "<input class='visually-hidden' type='file' name='questions[" + count + "][image]' id='questFile" + count + "' onchange='loadFile(event, this)'>" + 
                                "<label for='questFile" + count + "'>" +                               
                                    "<span class='btn border-primary'>Добавить</span>" + 
                                "</label>" + 
                            "</div>" + 
                        "</div>" + 


                        "<div class='question-inputs w-100 px-3'  style='max-width: 800px;'>" +         
                            "<div class='mb-3'>" + 
                               "<label for='title' class='form-label'>Вопрос</label>" +
                               "<div class='questions_"+ count + "_text' style='color: red'></div>" +  
                                "<input type='text' class='form-control' name='questions[" + count + "][text]' >" + 
                            "</div>" + 

                            "<input type='hidden' class='answerCount' value='1'>" +
                            "<input type='hidden' class='questCount' value='" + count + "'>" +

                            "<table class='variants'>" + 
                                "<tr>" + 
                                    "<td>Верный</td>" + 
                                   " <td><div class='questions_"+ count + "_correct' style='color: red;'></div></td>" +
                                "</tr>" + 
                                "<tr>" +
                                    "<td class='empty'></td>" +
                                    "<td ><div class='questions_"+ count + "_answer_0' style='color: red;'></div></td>" +
                               " </tr>"  +                                                            
                                "<tr class='answerVariant' id='mainRow'>" + 
                                    "<td><input type='checkbox' class='form-check-input' name='questions[" + count + "][correct][0]' value='" + count + "' checked></td>" + 
                                    "<td><input type='text' class='form-control' name='questions[" + count + "][answer][0]'></td>" + 
                                    "<td><div class='btn border-success mx-2' id='addAnswerBtn" + count  +"' onclick='addAnswer(this)' style='color:green'>+</div></td>" + 
                                    "<td><div class='btn border-danger' id='removeAnswerBtn" + count  +"' style='display: none; color: red;' onclick='removeAnswer(this)'>x</div></td>" +   
                                "</tr>" + 
                            "</table>" + 
                        "</div>" + 
                    "</div>";
}

function addAnswer(obj) {
    let answerCount = obj.closest('.question-inputs').querySelector('.answerCount');
    let questCount = obj.closest('.question-inputs').querySelector('.questCount');
    let tbody = obj.closest('tbody'); 
    let errorTr = document.createElement('tr');
    errorTr.innerHTML = '<td></td>' +
                       ' <td>' +
                            '<div class="questions_'+ questCount.value + '_answer_' + answerCount.value + '" style="color: red;"></div>' +
                        '</td> ' ;
    tbody.appendChild(errorTr);
    let answer = document.createElement('tr');
    answer.class = 'answerVariant';
    answer.innerHTML = '<td>' +
                            '<input type="checkbox" class="form-check-input" name="questions['+ questCount.value + '][correct][' + answerCount.value + ']" value="' + answerCount.value + '">' + 
                        '</td>' +
                        '<td>' +
                            '<input type="text" class="form-control" name="questions['+ questCount.value + '][answer][' + answerCount.value + ']">' +
                        '</td>'; 
    tbody.appendChild(answer); 
    answerCount.value = Number(answerCount.value) + 1;

    if (answerCount.value == 2) {
        document.getElementById('removeAnswerBtn' + questCount.value).style.display = 'block';
    }
}

function removeAnswer(obj) {
    let tbody = obj.closest('tbody'); 
    let questCount = obj.closest('.question-inputs').querySelector('.questCount');
    tbody.lastElementChild.remove();
    tbody.lastElementChild.remove();
    let answerCount = obj.closest('.question-inputs').querySelector('.answerCount');
    answerCount.value = Number(answerCount.value) - 1;

    if (answerCount.value == 1) {
        document.getElementById('removeAnswerBtn' + questCount.value).style.display = 'none';
    }
}


/*let displayRadioValue = function () {
    let type = document.getElementsByClassName('type');
      
    for(i = 0; i < type.length; i++) {
        if(type[i].checked) {
            document.getElementById(type[i].value).style.display  = "block";
        } else {
            document.getElementById(type[i].value).style.display  = "none";
        }
    }
}

window.onload =  displayRadioValue;*/




$(function(){
              
    $("#testStore").on('submit', function(e){
        e.preventDefault();

        $.ajax({
            url:$(this).attr('action'),
            method:$(this).attr('method'),
            data:new FormData(this),
            processData:false,
            dataType:'json',
            contentType:false,
            beforeSend:function(){
                $(document).find('div.error_message').text('');
            },
            success:function(data){
                if(data.status == 0){
                    $.each(data.error, function(prefix, val){
                        if(prefix.startsWith('questions.')) {
                            
                           $('div.' + prefix.replace(/\./g, '_')).text(val[0])
                        } else {
                           $('div.'+prefix+'_error').text(val[0]); 
                        }
                        

                    });                   

                }else{
                    window.location.href = data.route;                                     

                }
            }
        });
    });
});


