"use client";

import React, {
  createContext,
  useCallback,
  useContext,
  useEffect,
  useState,
} from "react";
import { useRouter } from "next/navigation";
import {
  fetchUser,
  login as apiLogin,
  logout as apiLogout,
  setAuthToken,
  AuthResponse,
  AuthUser,
} from "@/lib/api";

interface AuthContextValue {
  user: AuthUser | null;
  isAuthenticated: boolean;
  isLoading: boolean;
  login: (email: string, password: string) => Promise<void>;
  setAuth: (res: AuthResponse) => void;
  logout: () => Promise<void>;
  refreshUser: () => Promise<void>;
}

const AuthContext = createContext<AuthContextValue | undefined>(undefined);

const TOKEN_KEY = "leacent_auth_token";

function getStoredToken(): string | null {
  if (typeof window === "undefined") return null;
  try {
    return localStorage.getItem(TOKEN_KEY);
  } catch {
    return null;
  }
}

function storeToken(token: string | null) {
  if (typeof window === "undefined") return;
  try {
    if (token) localStorage.setItem(TOKEN_KEY, token);
    else localStorage.removeItem(TOKEN_KEY);
  } catch {
    // ignore
  }
}

export function AuthProvider({ children }: { children: React.ReactNode }) {
  const [user, setUser] = useState<AuthUser | null>(null);
  const [isLoading, setIsLoading] = useState(true);
  const router = useRouter();

  const refreshUser = useCallback(async () => {
    try {
      const u = await fetchUser();
      setUser(u);
    } catch {
      setUser(null);
    }
  }, []);

  // Restore session on mount if a token exists.
  useEffect(() => {
    let active = true;
    const token = getStoredToken();
    if (token) {
      setAuthToken(token);
      (async () => {
        try {
          const u = await fetchUser();
          if (active) setUser(u);
        } catch {
          if (active) {
            setUser(null);
            setAuthToken(null);
            storeToken(null);
          }
        } finally {
          if (active) setIsLoading(false);
        }
      })();
    } else {
      if (active) setIsLoading(false);
    }
    return () => {
      active = false;
    };
  }, [refreshUser]);

  const login = useCallback(async (email: string, password: string) => {
    setIsLoading(true);
    try {
      const res: AuthResponse = await apiLogin({ email, password });
      setAuthToken(res.access_token);
      storeToken(res.access_token);
      setUser(res.user);
    } finally {
      setIsLoading(false);
    }
  }, []);

  const logout = useCallback(async () => {
    await apiLogout();
    setAuthToken(null);
    storeToken(null);
    setUser(null);
    router.push("/auth-pages/sign-in");
  }, [router]);

  const setAuth = useCallback((res: AuthResponse) => {
    setAuthToken(res.access_token);
    storeToken(res.access_token);
    setUser(res.user);
  }, []);

  const value: AuthContextValue = {
    user,
    isAuthenticated: !!user,
    isLoading,
    login,
    setAuth,
    logout,
    refreshUser,
  };

  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
}

export function useAuth() {
  const ctx = useContext(AuthContext);
  if (!ctx) {
    throw new Error("useAuth must be used within an AuthProvider");
  }
  return ctx;
}

export default AuthContext;
