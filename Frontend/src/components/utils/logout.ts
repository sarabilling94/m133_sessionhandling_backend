import axios from 'axios';

const logout = () => {
  axios.get('http://localhost/haushaltsapp/Backend/Controllers/users/logout.php', { withCredentials: true }).then(res => {
    console.log(res.statusText);
    });
  };
  
  export default logout ;