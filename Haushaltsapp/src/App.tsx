import './App.css';
import Login from './components/login/Login';
import { BrowserRouter, Route, Routes } from "react-router-dom";
import Register from './components/register/Register';
import LoggedIn from './LoggedIn';
import NavbarLoggedIn from './components/navbar/NavbarLoggedIn';
import NavbarLoggedOut from './components/navbar/NavbarLoggedOut';
import Home from './components/home/Home';
import verifyLoginStatus from './components/utils/verifyLoginStatus';
import { useState } from 'react';
import TaskCalendar from './components/calendar/TaskCalendar';
import CreateGroup from './components/creategroup/CreateGroup';
import Invitations from './components/invitations/Invitations';

function App() {
  const [loggedIn, setLoggedIn] = useState(false);

  const checkUser = async () => {
    const statusCode = await verifyLoginStatus();
    console.log(statusCode);
    if (statusCode === "OK") {
      setLoggedIn(true);
    }
  }

  checkUser();

  console.log("loggedIn: ", loggedIn);

  return (
    <>
    {loggedIn ?
      <NavbarLoggedIn/>
      :
      <NavbarLoggedOut/>
    }
      {loggedIn ?
        <BrowserRouter >
          <Routes>
            <Route path="/Home" element={<Home />} />
            <Route path="/calendar" element={<TaskCalendar />} />
            <Route path="/creategroup" element={<CreateGroup />} />
            <Route path="/invitations" element={<Invitations />} />
          </Routes>
        </BrowserRouter>
        :
        <BrowserRouter >
          <Routes>
            <Route path="/" element={<Login />} />
            <Route path="/Register" element={<Register />} />
          </Routes>
        </BrowserRouter>
      }
    </>
  );
}

export default App;
