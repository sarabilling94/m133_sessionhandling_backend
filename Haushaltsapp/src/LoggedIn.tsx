import logout from "./components/utils/logout";
import verifyLoginStatus from "./components/utils/verifyLoginStatus";
import { useNavigate } from 'react-router-dom';

function LoggedIn(): JSX.Element {

  let navigate = useNavigate();
  const routeChange = () =>{
      let path = '/';
      navigate(path);
  }

  const checkUser = async () =>{
      const statusCode = await verifyLoginStatus();
      console.log(statusCode);
      if(!(statusCode === "OK")){
        routeChange();
      }
  }

  checkUser();
  
  return (
    <>
      <h2>You are logged in.</h2>
      <button onClick={checkUser}>checkuser</button>
      <button onClick={logout}>logout</button>
      </>
  );
}

export default LoggedIn;
