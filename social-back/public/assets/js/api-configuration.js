function sendAjaxRequest(url, method, data) {
    return new Promise(function(resolve, reject) {
      var xhr = new XMLHttpRequest();
      xhr.open(method, url, true);
      var token = document.querySelector('meta[name="csrf-token"]').content;
      xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');
      xhr.setRequestHeader('X-CSRF-TOKEN', token);
      xhr.send(data);
      xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
          resolve(xhr.responseText);
        } else {
          reject(new Error(xhr.statusText));
        }
      };
  
      xhr.onerror = function() {
        reject(new Error('Network error'));
      };
    });
}
  
function callRequest(apiEndPoint, method, data) {
    return new Promise( async function(resove,reject){
        try {
            const response = await sendAjaxRequest('http://127.0.0.1:8000' + apiEndPoint, method, data);
            let responseData =  {
              status: true,
              success: true,
              error: false,
              data: response
            };
            resove(response);
          } catch (error) {
            let errorResponseData = {
                status: false,
                success: false,
                error: error.message,
                data: null
            };
            reject(errorResponseData);
          }
    })
}