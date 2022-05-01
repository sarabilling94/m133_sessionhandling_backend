import axios from 'axios';

const verifyLoginStatus = async (): Promise<String> => {
  let statusCode = "Unauthorized";

  await axios.get('http://localhost/haushaltsapp/Backend/Controllers/checkuser.php', { withCredentials: true }).then(res => {
    if(res.statusText === "OK"){
      statusCode = "OK";
    }
    }).catch(error => {
      console.log(error);
  });
  return statusCode;
  };
  
  export default verifyLoginStatus ;

