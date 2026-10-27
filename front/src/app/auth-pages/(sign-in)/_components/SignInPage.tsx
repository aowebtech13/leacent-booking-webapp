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
import Image from "next/image";
import { useSearchParams, useRouter } from "next/navigation";
import { loginUser } from "@/lib/auth/action";
import { isRedirectError } from "next/dist/client/components/redirect-error";
import { POST_LOGIN_PATH } from "@/lib/auth/constants";
import { useAuth } from "@/lib/contexts/AuthContext";

const INITIAL_STATE = { error: null as string | null };

const SignInPage = () => {
  const router = useRouter();
  const searchParams = useSearchParams();
  const { isAuthenticated, isLoading: authLoading, setAuth } = useAuth();

  const [state, formAction, isPending] = useActionState(
    async (_prev: { error: string | null }, formData: FormData) => {
      try {
        const res = await loginUser(formData);
        if ((res as any)?.error) {
          return { error: (res as any).error };
        }
        // Store the session (token + user) before leaving the auth page,
        // otherwise the app renders as if the user was never signed in.
        setAuth(res as any);
        return INITIAL_STATE;
      } catch (err: any) {
        if (isRedirectError(err)) throw err;

        // Robust error extraction for production builds where 
        // class names like "ActionError" might get minified or stripped.
        const errorMessage =
          err?.message ||
          err?.data?.message ||
          (typeof err === "string" ? err : null);

        if (errorMessage) {
          return { error: errorMessage };
        }

        return { error: "Invalid credentials. Please try again." };
      }
    },
    INITIAL_STATE
  );

  const resetSent = searchParams.get("reset") === "sent";

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
                      <Image
                        src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1793002438/WhatsApp_Image_0008-10-26_at_01.07.28-removebg-preview-removebg-preview_giyzud.png"
                        alt="logo"
                        className="img-fluid"
                        width={201}
                        height={111}
                        priority
                      />
                    </span>
                  </div>
                  <div className="signup-bg-img">
                    <Image
                      src="/images/login/01.png"
                      alt="background"
                      className="img-fluid"
                      width={648}
                      height={577}
                      sizes="(max-width: 992px) 100vw, 50vw"
                      priority
                    />
                  </div>
                </div>
              </Col>
              <Col lg={6} className="form-contentbox">
                <div className="d-lg-none text-center mb-3">
                  <Image
                    src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1793002438/WhatsApp_Image_0008-10-26_at_01.07.28-removebg-preview-removebg-preview_giyzud.png"
                    alt="logo"
                    width={160}
                    height={93}
                    priority
                  />
                </div>
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
                          Login To Bookstore!
                        </h2>
                        <p>
                          Sign in with your data that you entered during your
                          registration
                        </p>
                      </Col>

                      {resetSent && (
                        <Col xs={12}>
                          <Alert color="success" className="mb-3">
                            Password reset link sent. Check your email and
                            follow the link to set a new password.
                          </Alert>
                        </Col>
                      )}

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
                            required
                            autoComplete="email"
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
                            required
                            autoComplete="current-password"
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