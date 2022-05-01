import { useState } from 'react';
import Calendar from 'react-calendar';
import { Title2 } from '../../theme';
import './taskcalendar.css';

function TaskCalendar(): JSX.Element {
  const [date, setDate] = useState(new Date());

  return (
    <>
      <div className='app'>
      <Title2>Kalender</Title2>
        <div className='calendar-container'>
          <Calendar onChange={setDate} value={date} />
        </div>
        <p className='text-center'>
          <span className='bold'>Selected Date:</span>{' '}
          {date.toDateString()}
        </p>
      </div>
    </>
  );
}

export default TaskCalendar;
