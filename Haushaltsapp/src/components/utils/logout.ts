import axios from 'axios';

const logout = () => {
  axios.get('http://localhost/haushaltsapp_backend/logout.php', { withCredentials: true }).then(res => {
    console.log(res.statusText);
    });
  };
  
  export default logout ;