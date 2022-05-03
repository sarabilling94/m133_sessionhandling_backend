import { useEffect, useState } from 'react';
import Calendar from 'react-calendar';
import { Button, Form, Input, Title2, Title3 } from '../../theme';
import 'react-calendar/dist/Calendar.css';
import './taskcalendar.css';
import { Formik } from 'formik';
import { MenuItem, Select } from '@mui/material';
import axios from 'axios';

function TaskCalendar(): JSX.Element {
  const [groups, setGroups] = useState([]);
  const [date, setDate] = useState(new Date());
  const [selectedGroupValue, setSelectedGroupValue] = useState("");

  const onSubmit = (name, checkbox) => {
    const obj = {
      task: name,
      group: selectedGroupValue,
      date: date.toISOString().split('T')[0]
    };

    if(checkbox){//onetimetask
      axios.post('http://localhost/haushaltsapp/Backend/Controllers/tasks/insertonetimetask.php', obj, { withCredentials: true })
      .then(res => {
        console.log(res.data);
      })
      .catch(error => {
        console.log(error.response);
      });
    }
    else{
      axios.post('http://localhost/haushaltsapp/Backend/Controllers/tasks/inserttask.php', obj, { withCredentials: true })
      .then(res => {
        console.log(res.data);
      })
      .catch(error => {
        console.log(error.response);
      });
    }
  };

  const getGroups = () => {
    axios.get('http://localhost/haushaltsapp/Backend/Controllers/groups/getgroups.php', { withCredentials: true })
      .then(res => {
        setGroups(res.data);
        console.log(groups);
      })
      .catch(error => {
        //console.log(error.response);
      })
  };


  const handleSelectChange = (e) => {
    setSelectedGroupValue(e.target.value);
  };

  useEffect(() => {
    getGroups();
  }, []);

  let selectedGroup;

  return (
    <>
      <div className='calendar'>
        <Title2>Kalender</Title2>
        <div className='calendar-container'>
          <Calendar onChange={setDate} value={date} />
        </div>

        <Title3>Aufgabe hinzufügen</Title3>
        <p className='text-center'>
          <span className='bold'>Gewähltes Datum:</span>{' '}
          {date.toDateString()}
        </p>

        {groups.length > 0 ?
          <Formik
            initialValues={{ name: '', checkbox: false }}
            onSubmit={(values, { setSubmitting }) => {
              setTimeout(() => {
                onSubmit(values.name, values.checkbox);
                setSubmitting(false);
              }, 400);
            }}
          >
            {({
              values,
              errors,
              touched,
              handleChange,
              handleBlur,
              handleSubmit,
              isSubmitting,
            }) => (
              <Form onSubmit={handleSubmit}>
                <Select
                style={{width: "310px", height: "40px", margin: "10px"}}
                  labelId="selectgroup-label"
                  id="selectgroup"
                  value={selectedGroup}
                  label="Gruppen"
                  onChange={handleSelectChange}
                >
                  {
                    groups.map((group, index) => {
                      return (
                        <MenuItem key={index} value={group}>{group}</MenuItem>
                      );
                    })
                  }
                </Select>
                <Input
                  type="name"
                  name="name"
                  onChange={handleChange}
                  onBlur={handleBlur}
                  value={values.name}
                />
                <span className='bold'>Einmalige Aufgabe?</span>{' '}
                <Input
                  type="checkbox"
                  name="checkbox"
                  onChange={handleChange}
                  onBlur={handleBlur}
                  value={values.name}
                />
                <Button type="submit" disabled={isSubmitting}>
                  Submit
                </Button>
              </Form>
            )}
          </Formik>
          : null
        }
      </div>
    </>
  );
}

export default TaskCalendar;
