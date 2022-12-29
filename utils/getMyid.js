
export async function getMyId(tokenValue) {

    let my_id;

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
    
    my_id = response.user_id;
    
    return my_id;
}

