import axios from 'axios';
import { Formik } from 'formik';
import { Button, Form, Input, Title2 } from '../../theme';
import { useEffect, useState } from 'react';
import { FormControl, InputLabel, MenuItem, Select } from '@mui/material';

function Invitations(): JSX.Element {
    const [invitations, setInvitations] = useState([]);

    const getInvitations = () => {
        axios.get('http://localhost/haushaltsapp_backend/getinvitations.php', { withCredentials: true })
            .then(res => {
                setInvitations(res.data);
                //console.log(invitations);
                //console.log(res.data);
            })
            .catch(error => {
                //console.log(error.response);
            })
    };

    const handleAcceptInvitation = (e) => {
        const obj = {
            groupName: e.target.id,
            sender: e.target.name
        };
        axios.post('http://localhost/haushaltsapp_backend/insertgroupuser.php', obj, { withCredentials: true })
            .then(res => {
                if(res.statusText === "Created"){
                    console.log("Invitation accepted.");
                }
                console.log(res.data);
            })
            .catch(error => {
            });
    };

    useEffect(() => {
        getInvitations();
    }, []);

    return (
        <>
            <table>
                <tr>
                    <th>Gruppeneinladung</th>
                    <th>Gesendet von</th>
                </tr>
                { invitations.length > 0 ?
                    invitations.map((invitation, index) => {
                        return (
                            <tr key={index}>
                                <td>{invitation.group}</td>
                                <td>{invitation.sender}</td>
                                <Button onClick={handleAcceptInvitation} name={invitation.sender} id={invitation.group} style={{ width: "100px" }}>Annehmen</Button>
                            </tr>
                        );
                    })
                    : null
                }
            </table>
        </>
    );
}

export default Invitations;
