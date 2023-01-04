
export async function getMyUtc(tokenValue) {

    let user_timezone;

    // 로컬 타임존도 보내기
    const date = new Date();    
    const utc = -(date.getTimezoneOffset() / 60);  

    const body = {
       
        token : tokenValue,
        user_timezone : utc,
    };
    const res = await fetch('/utils/utc.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
    });
    
    const response = await res.json();  
    
    user_timezone = response.user_timezone;
    
    return user_timezone;
}
