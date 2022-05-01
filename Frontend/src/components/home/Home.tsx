import './home.css';
import logout from "../utils/logout";
import verifyLoginStatus from "../utils/verifyLoginStatus";
import { useNavigate } from 'react-router-dom';
import { Title2, Text } from "../../theme";

function Home(): JSX.Element {

    let navigate = useNavigate();
    const routeChange = () => {
        let path = '/';
        navigate(path);
    }

    const checkUser = async () => {
        const statusCode = await verifyLoginStatus();
        console.log(statusCode);
        if (!(statusCode === "OK")) {
            routeChange();
        }
    }

    checkUser();

    return (
        <div>
            <Title2>Home</Title2>
            <Text>
                Sie haben sich erfolgreich eingeloggt. <br/>
                Klicken Sie auf "Neue Gruppe", um eine Gruppe zu erstellen,<br/>
                oder auf "Kalender", um ihre Haushalts-Aufgaben zu verwalten.
            </Text>
            <button onClick={logout}>logout</button>
        </div>
    );
}

export default Home;