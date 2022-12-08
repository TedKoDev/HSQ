<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./dist/output.css" rel="stylesheet">
        <title>Dialog</title>
        <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>
        <script>
        
        // 현재 날짜 객체 생성
        // const now = new Date();
        
        // console.log("1 : "+dayjs(now.getTime()).format('YYYY/MM/DD HH:mm'));
        // // UTC 시간과의 차이 계산하고 적용 (UTC 시간으로 만들기 위해)
        // const offset = (now.getTimezoneOffset() / 60);
        // now.setHours(now.getHours() + offset);    
        // console.log("2 : "+dayjs(now.getTime()).format('YYYY/MM/DD HH:mm'));
        // // 날짜 표시하기 전에 받아온 타임존 적용
        // // const string_to_int = parseInt(timezone);
        // console.log("timezone : "+9);
        // now.setHours(now.getHours() + 9);

        // console.log("3 : "+dayjs(now.getTime()).format('YYYY/MM/DD HH:mm'));

        const timezone = "9";
        // 현재 날짜 객체 생성
        const now = new Date();
        console.log("1 : "+dayjs(now.getTime()).format('YYYY/MM/DD HH:mm'));
        // UTC 시간과의 차이 계산하고 적용 (UTC 시간으로 만들기 위해)
        const offset = (now.getTimezoneOffset() / 60);
        now.setHours(now.getHours() + offset);    
        console.log("2 : "+dayjs(now.getTime()).format('YYYY/MM/DD HH:mm'));
        // 날짜 표시하기 전에 받아온 타임존 적용
        const string_to_int = parseInt(timezone);
        console.log("timezone : "+timezone);
        now.setHours(now.getHours() + string_to_int);
        console.log("3 : "+dayjs(now.getTime()).format('YYYY/MM/DD HH:mm'));
        // const s_to_i_value = parseInt(value);

        // console.log("now.getTime() : "+dayjs(now.getTime()).format('YYYY/MM/DD : hh:mm'));
        // console.log("dayjs(value) : "+dayjs(s_to_i_value).format('YYYY/MM/DD : hh:mm'));
        // if (dayjs(now.getTime()).format('YYYY/MM/DD : hh:mm') == dayjs(s_to_i_value).format('YYYY/MM/DD : hh:mm')) {

        // console.log("yes");
        // }
        // else {
        // console.log("no");
        // }

        </script>        
    </body>
</html>