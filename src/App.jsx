import { useState } from 'react'
/*import reactLogo from './assets/react.svg'
import viteLogo from '/vite.svg'
import './App.css'*/
import 'bootstrap/dist/css/bootstrap.min.css';
import { BrowserRouter, Routes, Route, Link } from 'react-router-dom';
import Userlist from './Component/Userlist';
import Add from './Component/Add';
import Edit from './Component/Edit';

function App() {
    return(
        <div className="container">
            <h1 className="mt-5 mb-5 text-center"><b>PHP React.js CRUD Application - <span className="text-primary">Create Delete Data API - 8</span></b></h1>
            <BrowserRouter   future={{
        v7_startTransition: true,
        v7_relativeSplatPath: true,
      }}>
            
                <Routes>
                    <Route path="/" element={<Userlist />} />
                    <Route path="/add" element={<Add />} />
                    <Route path="/edit/:user_id" element={<Edit />} />
                </Routes>
            </BrowserRouter>
        </div>
    )
}

export default App
