let type_num = 0;
let type_array = new Array();

function click_add_type() {

    let add_btn = document.getElementById("add_type_btn");
    // 현재 select의 값 가져오기
    let selete_type = document
        .getElementById("select_type")
        .value;
    // 새롭게 생성되는 타입들이 붙을 div 가져오기
    let type_list = document.getElementById("type_list");

    // 기존에 있는 type_array와 중복되지 않을 경우에만 표시
    if (!type_array.includes(selete_type)) {

        console.log(type_array[selete_type]);
        // 1증가
        type_num = type_num + 1;
        // 새로운 div 생성
        let type_item = document.createElement('div');
        // type_1 이런식으로 id 부여
        type_item.setAttribute("id", "type_" + type_num);
        

        console.log("pass");
        // 추가될 뷰 대입
        type_item.innerHTML = [
            '<div class = "flex bg-gray-500 mr-2 rounded-lg">', '<div class = "pl-2">' +
                    selete_type + '</div>',
            '<div class = "ml-1 px-1 text-white rounded-full" onclick = "delete_type(' + type_num + ')"> X</div>',
            '</div>'
        ].join("");

        // select를 div 아래에 연결
        type_list.appendChild(type_item);

        // array에 해당 type 추가
        type_array.push(selete_type);

    }
}

function delete_type(type_num) {

    // 해당 배열 삭제
    delete type_array[type_num - 1];

    // 삭제할 div 태그 가져오기
    let delete_div = document.getElementById("type_" + type_num);
    // 삭제
    delete_div.remove();
}

async function regisclass_btn() {

    // 전송할 수업명, 수업소개, 수업 유형, 수업료, 수업 레벨
    let cname = document
        .getElementById("class_name")
        .value;
    let cintro = document
        .getElementById('class_intro')
        .value;
    let price_30 = document
        .getElementById('price_30')
        .value;
    let price_60 = document
        .getElementById('price_60')
        .value;

    let level_from = document.getElementById("select_level_from").value;
    let level_to = document.getElementById("select_level_to").value;

    let level_total = level_from+'_'+level_to;

    // 수업 유형 array string으로 변환
    let type_list = type_array.join();

    // 수업료 보내는 형태로 데이터 가공 array 생성

    let price_array = new Array();
    // 30분, 60분용 json 생성
    let p_30 = new Object();
    let p_60 = new Object();

    // 각 json에 key, value 넣기
    p_30.time = "30";
    p_30.price = price_30;
    p_60.time = "60";
    p_60.price = price_60;

    // array에 json 넣기
    price_array.push(p_30);
    price_array.push(p_60);

    let test = JSON.stringify(price_array);

    console.log("level_total : "+level_total);

    let body = {
        token: checkCookie,
        cname: cname,
        cintro: cintro,
        people: 1,
        type: type_list,
        level: level_total,
        timeprice: test
    };
    let res = await fetch('#', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
    }).then(alert("수업이 등록되었습니다."), location.replace('../myclass/myclass.php'))

    let response = await res.json();

}