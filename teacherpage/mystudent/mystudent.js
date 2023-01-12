import { $, $_all } from "/utils/querySelector.js";
import { cookieName, getCookie, s3_url } from "/commenJS/cookie_modules.js";


let student_array;

const body = {
    
    token: getCookie(cookieName),       
    row: 24,
  };

const res = await fetch('/restapi/studentinfo.php', {
method: 'POST',
headers: {
    'Content-Type': 'application/json;charset=utf-8'
},
body: JSON.stringify(body)
});  

const response = await res.json();  


if (response.success == 'yes') {

    const result = response.result;   
    
    student_array = result;

    console.log(student_array)
   
    getStudentList(student_array);
}
else {
    console.log('통신 오류');
}

function getStudentList(result) {

    for (let i = 0; i < result.length; i++) {

        const user_id = result[i].user_id_student;
        const user_name = result[i].user_name;    
        const user_img = result[i].user_img;

        let user_src;
        if (user_img == null || user_img == 'default') {
    
            user_src = '/images_forHS/userImage_default.png';
        }
        else {
            user_src = s3_url+"Profile_Image/"+user_img;
        }

        const div = document.createElement('div');
        div.setAttribute("class", "w-1/6 flex flex-col border-2 rounded-md px-2 py-2 mb-2 shadow-md justify-center");
        div.innerHTML = `
            <img class = "image w-24 h-24 mx-auto border-2 border-gray-900 rounded-lg" src = ${user_src}></img>
            <span class = "text-xs text-center mt-1">${user_name}</span>
            <button class = "btn_${user_id} bg-gray-500 hover:bg-gray-600 text-white rounded-lg mt-1">히스토리</button>
            `;
       
        $('.studentList_div').append(div);

        console.log($('.image').className);

        $('.btn_'+user_id).addEventListener('click', () => {

            goStudentDetail(user_id, '../studentdetail/')
        })
    }
}


function goStudentDetail(user_id, url) {
        
    const form = document.createElement('form');
    form.setAttribute('method', 'get');    
    form.setAttribute('action', url);

    const hiddenField = document.createElement('input');
    hiddenField.setAttribute('type', 'hidden');
    hiddenField.setAttribute('name', 'user_id');
    hiddenField.setAttribute('value', user_id);    

    form.appendChild(hiddenField);    

    document.body.appendChild(form);

    form.submit();      
    
}

// 검색 버튼 클릭 시 해당 검색어가 포함되게 재정렬
const searchInput = $('.searchInput');
const searchBtn = $('.searchBtn');

function searchStudnet(student_array) {

    let search_array = new Array();
    for (let i = 0; i < student_array.length; i++) {
      
        if (student_array[i].user_name.includes(searchInput.value)) {
            
            search_array.push(student_array[i]);
        }       
    }

    return search_array;
}
searchBtn.addEventListener('click', () => {

    while($('.studentList_div').firstChild)  {

	    $('.studentList_div').firstChild.remove()
	}

    const search_array = searchStudnet(student_array);
    
    if (search_array.length == 0) {

        $('.studentList_div').innerHTML = `
            <span class = "mx-auto text-sm text-gray-700 py-2">검색 결과가 없습니다</span> 
        `;
    }
    else {
        getStudentList(search_array);
    }    
})


