// 수업 id, 강사 id 받아오기
const {class_id, teacher_id} = JSON.parse(localStorage.getItem("c_and_t_id"));

// 수업 id, 강사 id 선언
let C_id = class_id;
let T_id = teacher_id;


// 수업 정보, 강사 정보 가져와서 화면에 표시
getClassinfo(C_id);
getTeacherinfo(T_id);
getSchedule();

async function getClassinfo(C_id) {

    console.log("class_id : "+C_id);

    const body = {
    
        classid : C_id,
        clname : 1,
        cldisc : 1,
        cltype : 1,
        cllevel : 1,
        cltime : 1,
        clprice : 1,
      };
     
      const res = await fetch('../restapi/classinfo.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json;'
        },
        body: JSON.stringify(body)
      });  

    const response = await res.json();  

    // console.log(response.result);

    const result = response.result[0];

    // console.log(result);

    const clname = result.CL_Name;
    const cldisc = result.CL_Disc;
    const cltype = result.CL_Type;
    const cllevel = result.CL_Level;
    const price = result.tp;

    // 수업 정보와 관련된 id들 가져오기
    const c_name = document.getElementById("c_name");
    const c_disc = document.getElementById("c_disc");
    const c_type = document.getElementById("c_type");
    const c_level = document.getElementById("c_level");
    const c_price30 = document.getElementById("c_price30");
    const c_price60 = document.getElementById("c_price60");

    // 파싱한 json 대입
    c_name.innerText = clname;
    c_disc.innerText = cldisc;
    c_level.innerText = cllevel.replace('_', ' - ');
    c_price30.innerText = price[0];
    c_price60.innerText = price[1];

    // 수업 유형 파싱해서 넣기
    if ((cltype != 'default') && (cltype != null)) {              
     
      let type_string = cltype;            
  
      let type_array = type_string.split(',');
     
      for (let j = 0; j < type_array.length; j++) {

          let type_list = document.createElement('span');          
          type_list.innerHTML = ['<span class = "text-xs mr-1 ml-1 bg-gray-300 text-gray-800 mr-2 rounded-lg px-2">'+type_array[j]+'</span>'].join("");
          c_type.appendChild(type_list);  
      }                               
                  
  }     
}        
        
async function getTeacherinfo(T_id) {

    console.log("teacher_id : "+T_id);

    const body = {
    
        tusid : T_id,
        timg : 1,
        tname : 1,
        tintro : 1,
        tcountry : 1,
        tresidence : 1,
        tspecial : 1,
        tlanguage : 1,
      };
     
      const res = await fetch('../restapi/teacherinfo.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json;'
        },
        body: JSON.stringify(body)
      });  

    const response = await res.json();    
        
    console.log(response);

    const result = response.result[0];

    const t_name = result.U_Name;
    const t_img = result.U_D_Img;
    const t_special = result.U_T_Special;
    const t_intro = result.U_T_Intro;
    const t_country = result.U_D_Country;
    const t_residence = result.U_D_Residence;
    const t_language = result.U_D_Language;

    // 강사 정보와 관련된 id들 가져오기
    const name_t = document.getElementById("t_name");
    const img_t = document.getElementById("t_img");
    const certi_t = document.getElementById("t_certi");
    const intro_t = document.getElementById("t_intro");
    const country_t = document.getElementById("t_country");
    const residence_t = document.getElementById("t_residence");
    const language_t = document.getElementById("t_speaks");

    // 파싱한 json 대입
    name_t.innerText = t_name;
    country_t.innerText = t_country+"출신";
    residence_t.innerText = t_residence+"거주";
    intro_t.innerText = t_intro;

    if (t_special == "default") {
      certi_t.innerText = '커뮤니티 튜터';
    }
    else {
      certi_t.innerText = '전문 강사';
    }
    img_t.setAttribute("src", "../editprofile/image/"+t_img);

    // 구사 가능 언어 대입
    const json_parse = JSON.parse(t_language);                  
           
    for (let key_l in json_parse) {

      let language_list = document.createElement('span');          
      language_list.innerHTML = ['<span class = "mr-2">'+key_l+' : '+json_parse[key_l]+'</span>'].join("");
      language_t.appendChild(language_list);
               
    }  

}

async function getSchedule() {

}

