
export async function getMyUtc(tokenValue) {

    let utc;

    const body = {
       
        token : tokenValue
    };
    const res = await fetch('/utils/utc.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
    });
    
    const response = await res.json();  
    
    utc = response.user_timezone;
    
    return utc;
}
