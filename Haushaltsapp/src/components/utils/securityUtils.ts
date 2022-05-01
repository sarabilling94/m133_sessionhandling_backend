import axios from 'axios';

export const checkOwnerRights= async (groupName: String): Promise<String> => {
  let statusCode = "Unauthorized";

  const obj = {
    groupName: groupName
  };

  await axios.post('http://localhost/haushaltsapp_backend/checkownerrights.php', obj, { withCredentials: true })
  .then(res => {
    if(res.statusText === "OK"){
      statusCode = "OK";
      console.log("allowed");
    }
    }).catch(error => {
      console.log(error);
      console.log("forbidden");
  });
  return statusCode;
  };
