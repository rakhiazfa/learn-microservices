import { useAuth } from "@/services/auth/auth.hook";
import { Avatar } from "@nextui-org/avatar";
import { Button } from "@nextui-org/button";
import {
    Dropdown,
    DropdownItem,
    DropdownMenu,
    DropdownTrigger,
} from "@nextui-org/dropdown";
import { Key } from "react";
import { Link, useNavigate } from "react-router-dom";

const Topbar = () => {
    const navigate = useNavigate();
    const { user, signOut } = useAuth();

    const handleDropdownAction = async (key: Key) => {
        if (key === "sign-out") {
            const isSuccess = await signOut();

            if (isSuccess) {
                navigate("/auth/signin");
            }
        }
    };

    return (
        <header className="relative w-full flex items-center h-[67.5px] border-b border-gray-300 shadow-xxs">
            <div className="app-container w-full flex justify-between items-center">
                <div>
                    <span className="text-xl font-semibold tracking-wide">
                        Merdekalio
                    </span>
                </div>
                <div>
                    {user ? (
                        <Dropdown>
                            <DropdownTrigger>
                                <button className="outline-none flex items-center gap-3">
                                    <div className="flex flex-col items-end">
                                        <span className="block text-xs font-medium tracking-wide">
                                            {user.name}
                                        </span>
                                        <span className="block text-[0.7rem] tracking-wide">
                                            {user.roles
                                                .map((role) => role.name)
                                                .join(" | ")}
                                        </span>
                                    </div>
                                    <Avatar />
                                </button>
                            </DropdownTrigger>
                            <DropdownMenu
                                aria-label="User dropdown actions"
                                onAction={handleDropdownAction}
                            >
                                <DropdownItem key="profile">
                                    Profile
                                </DropdownItem>
                                <DropdownItem key="settings">
                                    Settings
                                </DropdownItem>
                                <DropdownItem key="sign-out">
                                    Sign Out
                                </DropdownItem>
                            </DropdownMenu>
                        </Dropdown>
                    ) : (
                        <Link to="/auth/signin">
                            <Button size="sm" color="primary">
                                Sign In
                            </Button>
                        </Link>
                    )}
                </div>
            </div>
        </header>
    );
};

export default Topbar;
