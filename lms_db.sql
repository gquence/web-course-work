--
-- PostgreSQL database dump
--

-- Dumped from database version 11.7 (Ubuntu 11.7-0ubuntu0.19.10.1)
-- Dumped by pg_dump version 11.7 (Ubuntu 11.7-0ubuntu0.19.10.1)

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

--
-- Name: e_employment_status; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE public.e_employment_status AS ENUM (
    'Fired',
    'Trainee',
    'Full time',
    'Part time'
);


ALTER TYPE public.e_employment_status OWNER TO postgres;

--
-- Name: e_learning_type; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE public.e_learning_type AS ENUM (
    'full time',
    'distance',
    'evening'
);


ALTER TYPE public.e_learning_type OWNER TO postgres;

--
-- Name: e_lesson_control_type; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE public.e_lesson_control_type AS ENUM (
    'Homework',
    'Exam'
);


ALTER TYPE public.e_lesson_control_type OWNER TO postgres;

--
-- Name: e_ped_position; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE public.e_ped_position AS ENUM (
    'Lecturer',
    'Sr. Lecturer',
    'Department Head',
    'Dean',
    'Vice-Dean',
    'Rector',
    'Vice-Rector',
    'Docent'
);


ALTER TYPE public.e_ped_position OWNER TO postgres;

--
-- Name: group_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.group_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.group_id OWNER TO postgres;

--
-- Name: lesson_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.lesson_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.lesson_id OWNER TO postgres;

--
-- Name: position_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.position_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.position_id OWNER TO postgres;

--
-- Name: subj_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.subj_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.subj_id OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: t_groups; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.t_groups (
    group_id integer DEFAULT nextval('public.group_id'::regclass) NOT NULL,
    group_name character varying(20) NOT NULL,
    start_date date DEFAULT CURRENT_DATE NOT NULL,
    end_date date DEFAULT (CURRENT_DATE + '4 years'::interval) NOT NULL,
    learning_type public.e_learning_type DEFAULT 'full time'::public.e_learning_type NOT NULL
);


ALTER TABLE public.t_groups OWNER TO postgres;

--
-- Name: t_lessons; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.t_lessons (
    lesson_id integer DEFAULT nextval('public.lesson_id'::regclass) NOT NULL,
    name character varying(30) NOT NULL,
    description character varying(100) NOT NULL,
    lesson_control_type public.e_lesson_control_type DEFAULT 'Homework'::public.e_lesson_control_type NOT NULL,
    subj_id integer NOT NULL,
    theory_path character varying(255) NOT NULL,
    recomendations_for_solving_path character varying(255) NOT NULL,
    author_uid integer NOT NULL
);


ALTER TABLE public.t_lessons OWNER TO postgres;

--
-- Name: t_lessons_to_users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.t_lessons_to_users (
    lesson_id integer NOT NULL,
    uid integer NOT NULL,
    open_or_not boolean DEFAULT false
);


ALTER TABLE public.t_lessons_to_users OWNER TO postgres;

--
-- Name: t_subj_to_users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.t_subj_to_users (
    subj_id integer NOT NULL,
    uid integer NOT NULL,
    open_or_not boolean DEFAULT false
);


ALTER TABLE public.t_subj_to_users OWNER TO postgres;

--
-- Name: t_subjects; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.t_subjects (
    subj_id integer DEFAULT nextval('public.subj_id'::regclass) NOT NULL,
    name character varying(30) NOT NULL,
    description character varying(100) NOT NULL,
    author_uid integer NOT NULL
);


ALTER TABLE public.t_subjects OWNER TO postgres;

--
-- Name: task_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.task_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.task_id OWNER TO postgres;

--
-- Name: t_tasks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.t_tasks (
    task_id integer DEFAULT nextval('public.task_id'::regclass) NOT NULL,
    lesson_id integer NOT NULL,
    question_path character varying(255) NOT NULL,
    corr_answer character varying(40),
    answers character varying(30)[]
);


ALTER TABLE public.t_tasks OWNER TO postgres;

--
-- Name: t_tasks_result; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.t_tasks_result (
    task_id integer NOT NULL,
    uid integer NOT NULL,
    correct boolean DEFAULT false,
    users_ans character varying(30)
);


ALTER TABLE public.t_tasks_result OWNER TO postgres;

--
-- Name: uid_main; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.uid_main
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.uid_main OWNER TO postgres;

--
-- Name: t_users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.t_users (
    uid integer DEFAULT nextval('public.uid_main'::regclass) NOT NULL,
    surname character varying(12) NOT NULL,
    name character varying(12) NOT NULL,
    stud_or_pedago boolean DEFAULT true NOT NULL,
    status boolean DEFAULT true NOT NULL,
    login character varying(30) NOT NULL,
    password_hash character varying(64) NOT NULL,
    password_salt character varying(64) NOT NULL,
    email character varying(64)
);


ALTER TABLE public.t_users OWNER TO postgres;

--
-- Name: uid_pedago; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.uid_pedago
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.uid_pedago OWNER TO postgres;

--
-- Name: t_users_pedago; Type: TABLE; Schema: public; Owner: gquence
--

CREATE TABLE public.t_users_pedago (
    uid_pedago integer DEFAULT nextval('public.uid_pedago'::regclass) NOT NULL,
    uid integer NOT NULL,
    us_right_id integer NOT NULL,
    employment_status public.e_employment_status DEFAULT 'Full time'::public.e_employment_status NOT NULL,
    ped_position public.e_ped_position DEFAULT 'Lecturer'::public.e_ped_position NOT NULL
);


ALTER TABLE public.t_users_pedago OWNER TO gquence;

--
-- Name: us_right_id; Type: SEQUENCE; Schema: public; Owner: gquence
--

CREATE SEQUENCE public.us_right_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.us_right_id OWNER TO gquence;

--
-- Name: t_users_rights; Type: TABLE; Schema: public; Owner: gquence
--

CREATE TABLE public.t_users_rights (
    us_right_id integer DEFAULT nextval('public.us_right_id'::regclass) NOT NULL,
    r_subj boolean DEFAULT false NOT NULL,
    w_subj boolean DEFAULT false NOT NULL,
    x_subj boolean DEFAULT false NOT NULL,
    r_lesson boolean DEFAULT false NOT NULL,
    w_lesson boolean DEFAULT false NOT NULL,
    x_lesson boolean DEFAULT false NOT NULL,
    r_tasks boolean DEFAULT false NOT NULL,
    w_tasks boolean DEFAULT false NOT NULL,
    x_tasks boolean DEFAULT false NOT NULL,
    r_users boolean DEFAULT false NOT NULL,
    w_users boolean DEFAULT false NOT NULL
);


ALTER TABLE public.t_users_rights OWNER TO gquence;

--
-- Name: uid_stud; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.uid_stud
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.uid_stud OWNER TO postgres;

--
-- Name: t_users_stud; Type: TABLE; Schema: public; Owner: gquence
--

CREATE TABLE public.t_users_stud (
    uid_stud integer DEFAULT nextval('public.uid_stud'::regclass) NOT NULL,
    uid integer NOT NULL,
    group_id integer NOT NULL,
    studying_now boolean DEFAULT true NOT NULL
);


ALTER TABLE public.t_users_stud OWNER TO gquence;

--
-- Data for Name: t_groups; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.t_groups (group_id, group_name, start_date, end_date, learning_type) FROM stdin;
1	M3O-335-B17	2020-05-26	2024-05-26	full time
2	name_group	2020-02-01	2024-05-28	full time
3	test	2020-05-28	2024-05-28	full time
4	test5	2019-10-12	2024-05-28	evening
6	test2	2020-05-28	2024-05-28	full time
7	Distance_group_1	2020-05-28	2024-05-28	distance
\.


--
-- Data for Name: t_lessons; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.t_lessons (lesson_id, name, description, lesson_control_type, subj_id, theory_path, recomendations_for_solving_path, author_uid) FROM stdin;
2	differ	newdescription	Exam	1	hahahah	no[e	18
4	integral	you will hate us	Homework	1	never gonna give you up	never gonna let you down	18
5	metalls	metalls	Exam	3	metalls	metalls	18
\.


--
-- Data for Name: t_lessons_to_users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.t_lessons_to_users (lesson_id, uid, open_or_not) FROM stdin;
\.


--
-- Data for Name: t_subj_to_users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.t_subj_to_users (subj_id, uid, open_or_not) FROM stdin;
\.


--
-- Data for Name: t_subjects; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.t_subjects (subj_id, name, description, author_uid) FROM stdin;
1	math	DO YOU KNOW WHAT THE MEANING OF THE PAIN???	18
3	Chemistry	Here we go again.. to burn out kitchen	18
\.


--
-- Data for Name: t_tasks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.t_tasks (task_id, lesson_id, question_path, corr_answer, answers) FROM stdin;
3	2	are you?	you	{heee,you,asd}
5	5	how many	many	{many,"not many"}
\.


--
-- Data for Name: t_tasks_result; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.t_tasks_result (task_id, uid, correct, users_ans) FROM stdin;
\.


--
-- Data for Name: t_users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.t_users (uid, surname, name, stud_or_pedago, status, login, password_hash, password_salt, email) FROM stdin;
1	sed	alex	t	t	NikolyaV	pass_hash	pass_salt	\N
15	sur_pedago	pedago	f	t	test_ped	ymmJeZr0fQPzw	ym5qOIKCPxgvVMa1	\N
17	sur_pedago	pedago	t	t	test_ped1	laVRBHPZz13UE	laThscCADGE6VdtN	\N
14	testsurname	test_1	t	t	monitoring_login	rfkXTed7cy1Sg	rfZAk2OYL1hmPJQM	test@mai.ru
18	Chernova	Anastasiya	f	t	NChernova	hzYOZXLezfuX.	hzO4TFlI3XPdcRC5	pen@yandex.ru
19	get out	of me 	t	t	ateo_tt	EB6YKxxsVTZqE	EBrZ3MP2RCcKHLDq	\N
\.


--
-- Data for Name: t_users_pedago; Type: TABLE DATA; Schema: public; Owner: gquence
--

COPY public.t_users_pedago (uid_pedago, uid, us_right_id, employment_status, ped_position) FROM stdin;
\.


--
-- Data for Name: t_users_rights; Type: TABLE DATA; Schema: public; Owner: gquence
--

COPY public.t_users_rights (us_right_id, r_subj, w_subj, x_subj, r_lesson, w_lesson, x_lesson, r_tasks, w_tasks, x_tasks, r_users, w_users) FROM stdin;
\.


--
-- Data for Name: t_users_stud; Type: TABLE DATA; Schema: public; Owner: gquence
--

COPY public.t_users_stud (uid_stud, uid, group_id, studying_now) FROM stdin;
\.


--
-- Name: group_id; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.group_id', 7, true);


--
-- Name: lesson_id; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.lesson_id', 5, true);


--
-- Name: position_id; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.position_id', 1, false);


--
-- Name: subj_id; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.subj_id', 4, true);


--
-- Name: task_id; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.task_id', 5, true);


--
-- Name: uid_main; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.uid_main', 22, true);


--
-- Name: uid_pedago; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.uid_pedago', 1, false);


--
-- Name: uid_stud; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.uid_stud', 1, false);


--
-- Name: us_right_id; Type: SEQUENCE SET; Schema: public; Owner: gquence
--

SELECT pg_catalog.setval('public.us_right_id', 1, false);


--
-- Name: t_groups t_groups_group_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_groups
    ADD CONSTRAINT t_groups_group_name_key UNIQUE (group_name);


--
-- Name: t_groups t_groups_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_groups
    ADD CONSTRAINT t_groups_pkey PRIMARY KEY (group_id);


--
-- Name: t_lessons t_lessons_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_lessons
    ADD CONSTRAINT t_lessons_pkey PRIMARY KEY (lesson_id);


--
-- Name: t_lessons_to_users t_lessons_to_users_uid_lesson_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_lessons_to_users
    ADD CONSTRAINT t_lessons_to_users_uid_lesson_id_key UNIQUE (uid, lesson_id);


--
-- Name: t_subj_to_users t_subj_to_users_uid_subj_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_subj_to_users
    ADD CONSTRAINT t_subj_to_users_uid_subj_id_key UNIQUE (uid, subj_id);


--
-- Name: t_subjects t_subjects_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_subjects
    ADD CONSTRAINT t_subjects_pkey PRIMARY KEY (subj_id);


--
-- Name: t_tasks t_tasks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_tasks
    ADD CONSTRAINT t_tasks_pkey PRIMARY KEY (task_id);


--
-- Name: t_tasks_result t_tasks_result_uid_task_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_tasks_result
    ADD CONSTRAINT t_tasks_result_uid_task_id_key UNIQUE (uid, task_id);


--
-- Name: t_users t_users_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_users
    ADD CONSTRAINT t_users_email_key UNIQUE (email);


--
-- Name: t_users t_users_login_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_users
    ADD CONSTRAINT t_users_login_key UNIQUE (login);


--
-- Name: t_users_pedago t_users_pedago_pkey; Type: CONSTRAINT; Schema: public; Owner: gquence
--

ALTER TABLE ONLY public.t_users_pedago
    ADD CONSTRAINT t_users_pedago_pkey PRIMARY KEY (uid_pedago);


--
-- Name: t_users_pedago t_users_pedago_uid_key; Type: CONSTRAINT; Schema: public; Owner: gquence
--

ALTER TABLE ONLY public.t_users_pedago
    ADD CONSTRAINT t_users_pedago_uid_key UNIQUE (uid);


--
-- Name: t_users t_users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_users
    ADD CONSTRAINT t_users_pkey PRIMARY KEY (uid);


--
-- Name: t_users_rights t_users_rights_pkey; Type: CONSTRAINT; Schema: public; Owner: gquence
--

ALTER TABLE ONLY public.t_users_rights
    ADD CONSTRAINT t_users_rights_pkey PRIMARY KEY (us_right_id);


--
-- Name: t_users_stud t_users_stud_pkey; Type: CONSTRAINT; Schema: public; Owner: gquence
--

ALTER TABLE ONLY public.t_users_stud
    ADD CONSTRAINT t_users_stud_pkey PRIMARY KEY (uid_stud);


--
-- Name: t_users_stud t_users_stud_uid_key; Type: CONSTRAINT; Schema: public; Owner: gquence
--

ALTER TABLE ONLY public.t_users_stud
    ADD CONSTRAINT t_users_stud_uid_key UNIQUE (uid);


--
-- Name: t_lessons t_lessons_author_uid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_lessons
    ADD CONSTRAINT t_lessons_author_uid_fkey FOREIGN KEY (author_uid) REFERENCES public.t_users(uid);


--
-- Name: t_lessons t_lessons_subj_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_lessons
    ADD CONSTRAINT t_lessons_subj_id_fkey FOREIGN KEY (subj_id) REFERENCES public.t_subjects(subj_id);


--
-- Name: t_lessons_to_users t_lessons_to_users_lesson_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_lessons_to_users
    ADD CONSTRAINT t_lessons_to_users_lesson_id_fkey FOREIGN KEY (lesson_id) REFERENCES public.t_lessons(lesson_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: t_lessons_to_users t_lessons_to_users_uid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_lessons_to_users
    ADD CONSTRAINT t_lessons_to_users_uid_fkey FOREIGN KEY (uid) REFERENCES public.t_users(uid) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: t_subj_to_users t_subj_to_users_subj_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_subj_to_users
    ADD CONSTRAINT t_subj_to_users_subj_id_fkey FOREIGN KEY (subj_id) REFERENCES public.t_subjects(subj_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: t_subj_to_users t_subj_to_users_uid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_subj_to_users
    ADD CONSTRAINT t_subj_to_users_uid_fkey FOREIGN KEY (uid) REFERENCES public.t_users(uid) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: t_subjects t_subjects_author_uid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_subjects
    ADD CONSTRAINT t_subjects_author_uid_fkey FOREIGN KEY (author_uid) REFERENCES public.t_users(uid);


--
-- Name: t_tasks t_tasks_lesson_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_tasks
    ADD CONSTRAINT t_tasks_lesson_id_fkey FOREIGN KEY (lesson_id) REFERENCES public.t_lessons(lesson_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: t_tasks_result t_tasks_result_task_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_tasks_result
    ADD CONSTRAINT t_tasks_result_task_id_fkey FOREIGN KEY (task_id) REFERENCES public.t_tasks(task_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: t_tasks_result t_tasks_result_uid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.t_tasks_result
    ADD CONSTRAINT t_tasks_result_uid_fkey FOREIGN KEY (uid) REFERENCES public.t_users(uid) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: t_users_pedago t_users_pedago_uid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gquence
--

ALTER TABLE ONLY public.t_users_pedago
    ADD CONSTRAINT t_users_pedago_uid_fkey FOREIGN KEY (uid) REFERENCES public.t_users(uid) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: t_users_pedago t_users_pedago_us_right_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gquence
--

ALTER TABLE ONLY public.t_users_pedago
    ADD CONSTRAINT t_users_pedago_us_right_id_fkey FOREIGN KEY (us_right_id) REFERENCES public.t_users_rights(us_right_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: t_users_stud t_users_stud_group_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gquence
--

ALTER TABLE ONLY public.t_users_stud
    ADD CONSTRAINT t_users_stud_group_id_fkey FOREIGN KEY (group_id) REFERENCES public.t_groups(group_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: t_users_stud t_users_stud_uid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gquence
--

ALTER TABLE ONLY public.t_users_stud
    ADD CONSTRAINT t_users_stud_uid_fkey FOREIGN KEY (uid) REFERENCES public.t_users(uid) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

