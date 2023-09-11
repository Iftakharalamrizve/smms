async function agentOnLoadOperation()
{
    try {
        openLoader();
        let response = await callRequest('/agent-assign-in-queues','POST');
        console.log(response);
        closeLoader();
        return response;
    } catch (error) {
        closeLoader();
    }
}

async function getsms()
{
    try {
        openLoader();
        let response = await callRequest('/get-sms','POST');
        console.log(response);
        closeLoader();
        return response;
    } catch (error) {
        closeLoader();
    }
}

async function test()
{
    try {
        openLoader();
        console.log("Information")
        let response = await callRequest('/test','POST');
        console.log(response);
        closeLoader();
        return response;
    } catch (error) {
        closeLoader();
    }
}

async function complete()
{
    try {
        openLoader();
        let response = await callRequest('/complete','GET');
        console.log(response);
        closeLoader();
        return response;
    } catch (error) {
        closeLoader();
    }
}
closeLoader();
agentOnLoadOperation()
// getsms();
// complete();
test();