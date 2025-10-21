--
-- PostgreSQL database dump
--

\restrict VicyTnS347NDaf96AQ1LXOcHoO4dMc6lK89FmXOgJvpL2Thg96Ae54o4gcDkAS5

-- Dumped from database version 15.14
-- Dumped by pg_dump version 15.14

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: users; Type: TABLE; Schema: public; Owner: devuser
--

CREATE TABLE public.users (
    id integer NOT NULL,
    firstname character varying(100),
    lastname character varying(100),
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    validation_token character varying(64),
    email_verified boolean DEFAULT false,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.users OWNER TO devuser;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: devuser
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO devuser;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: devuser
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: devuser
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: devuser
--

COPY public.users (id, firstname, lastname, email, password, validation_token, email_verified, created_at) FROM stdin;
1	Johan	Yorick	prisojohan2@gmail.com	$2y$10$wuoLL5.g8sbtQgotAVvTves5YFYfr.prF2.Ku222oUJqT.h4qqP.m	\N	f	2025-10-03 21:08:58.157519
2	Johan	Yorick	johanpriso10@gmail.com	$2y$10$oyVUtTMI8xXPQ6GW8XBrFOiZL4oX162X1avPgMAIzdV.hI8LlztMS	81314b63c900895d72075c806a82a562de67e9ff9a3f614dba35a4a1e74c9b97	f	2025-10-03 21:11:05.152897
3	Johan	Jojo	johanpriso2@gmail.com	$2y$10$zA3c2XBAj4ETx8Ye5OwoaOL.GSR01Kn1GNltIZPzLjzv.MGynN8Iq	64b91596a7e700680c72765cdb30504c74bd0e100880a641750e7408253edcfe	f	2025-10-03 21:38:45.209366
4	Jotaro	Kirijo	jotarokirijo@gmail.com	$2y$10$9dPUqTHMozhdNmL4QRsO.O7cYDKsFlQB6ynXDpYHwPd.5xO/8EirS	0375d0a5dc54aab680d57b935d0f210988162524ed728d5d1902999550322511	f	2025-10-03 21:43:05.892614
\.


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: devuser
--

SELECT pg_catalog.setval('public.users_id_seq', 4, true);


--
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: devuser
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: devuser
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--

\unrestrict VicyTnS347NDaf96AQ1LXOcHoO4dMc6lK89FmXOgJvpL2Thg96Ae54o4gcDkAS5

