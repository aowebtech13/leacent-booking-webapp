"use client";
import React, { useActionState, useEffect } from "react";
import {
  Container,
  Row,
  Col,
  Form,
  FormGroup,
  Label,
  Input,
  Button,
  Spinner,
  Alert,
} from "reactstrap";
import Link from "next/link";
import { useRouter } from "next/navigation";
import { loginUser, POST_LOGIN_PATH } from "@/lib/auth/action";
import { useAuth } from "@/lib/contexts/AuthContext";

const INITIAL_STATE = { error: null as string | null };

const SignInPage = () => {
  const router = useRouter();
  const { isAuthenticated, isLoading: authLoading, setAuth } = useAuth();

  const [state, formAction, isPending] = useActionState(
    async (_prev: { error: string | null }, formData: FormData) => {
      try {
        const res = await loginUser(formData);
        // Store the session (token + user) before leaving the auth page,
        // otherwise the app renders as if the user was never signed in.
        setAuth(res);
        return INITIAL_STATE;
      } catch (err: any) {
        if (err?.name === "ActionError") {
          return { error: err.message };
        }
        return { error: err?.message || "Invalid credentials" };
      }
    },
    INITIAL_STATE
  );

  // Send signed in users to the app instead of the sign in form.
  useEffect(() => {
    if (!authLoading && isAuthenticated) {
      router.replace(POST_LOGIN_PATH);
    }
  }, [authLoading, isAuthenticated, router]);

  return (
    <div className="sign-in-bg">
      <div className="app-wrapper d-block">
        <div className="main-container">
          <Container>
            <Row className="sign-in-content-bg">
              <Col lg={6} className="image-contentbox d-none d-lg-block">
                <div className="form-container">
                  <div className="signup-content mt-4">
                    <span>
                      <img
                        src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1791759399/leacent%20webapp.png"
                        alt="logo"
                        className="img-fluid"
                      />
                    </span>
                  </div>
                  <div className="signup-bg-img">
                    <img
                      src="/images/login/01.png"
                      alt="background"
                      className="img-fluid"
                    />
                  </div>
                </div>
              </Col>
              <Col lg={6} className="form-contentbox">
                <div className="form-container">
                  <Form
                    action={formAction}
                    className="app-form rounded-control"
                  >
                    <Row>
                      <Col
                        xs={12}
                        className="mb-5 mt-5 text-center text-lg-start"
                      >
                        <h2 className="text-primary-dark f-w-600">
                          Welcome To Bookstore!
                        </h2>
                        <p>
                          Sign in with your data that you entered during your
                          registration
                        </p>
                      </Col>

                      {state.error && (
                        <Col xs={12}>
                          <Alert color="danger" className="mb-3">
                            {state.error}
                          </Alert>
                        </Col>
                      )}

                      <Col xs={12}>
                        <FormGroup>
                          <Label for="email">Email</Label>
                          <Input
                            className="form-control"
                            id="email"
                            name="email"
                            placeholder="Enter Your Email"
                            type="email"
                          />
                        </FormGroup>
                      </Col>

                      <Col xs={12}>
                        <FormGroup>
                          <Label for="password">Password</Label>
                          <Link
                            href="/auth-pages/forgot-password"
                            className="link-primary-dark float-end"
                          >
                            Forgot Password?
                          </Link>
                          <Input
                            id="password"
                            name="password"
                            placeholder="Enter Your Password"
                            type="password"
                          />
                        </FormGroup>
                      </Col>

                      <Col xs={12}>
                        <FormGroup check className="mb-3">
                          <Input type="checkbox" id="checkDefault" />
                          <Label
                            check
                            for="checkDefault"
                            className="text-secondary"
                          >
                            Remember me
                          </Label>
                        </FormGroup>
                      </Col>

                      <Col xs={12}>
                        <div className="mb-3">
                          <Button
                            type="submit"
                            color="light-primary"
                            className="w-100"
                            disabled={isPending}
                          >
                            {isPending ? <Spinner size="sm" /> : "Sign In"}
                          </Button>
                        </div>
                      </Col>

                      <Col xs={12} className="text-center text-lg-start mt-3">
                        Don&apos;t have an account?
                        <Link
                          href="/auth-pages/sign-up"
                          className="link-primary text-decoration-underline ms-1"
                        >
                          Sign up
                        </Link>
                      </Col>
                    </Row>
                  </Form>
                </div>
              </Col>
            </Row>
          </Container>
        </div>
      </div>
    </div>
  );
};

export default SignInPage;
