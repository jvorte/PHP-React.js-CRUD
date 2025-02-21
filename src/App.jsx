

import './App.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Userlist from './Component/Userlist';
import Add from './Component/Add';
import Edit from './Component/Edit';

function App() {
    return(
        <div className="container">
            <h1 className="title mt-5 mb-5 text-center"><b>PHP React.js CRUD Application - <span className="text-primary">List</span></b></h1>
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
