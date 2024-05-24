import { Outlet } from "react-router-dom";
import Topbar from "../container/topbar";

const Default = () => {
    return (
        <>
            <Topbar />
            <div className="my-5">
                <Outlet />
            </div>
        </>
    );
};

export default Default;
